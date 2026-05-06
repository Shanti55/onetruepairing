<?php

namespace App\Http\Controllers\ServiceProviders;

use App\Http\Controllers\Controller;
use App\Models\JobBid;
use App\Models\JobPost;
use App\Models\User;
use App\Notifications\BidOutbidNotification;
use App\Events\BidPlaced;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class JobBidController extends Controller
{
    // ── Store Bid ─────────────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $job      = JobPost::findOrFail($request->job_id);
        $vendorId = Auth::id();

        if (
            $job->status === 'closed' ||
            ($job->auction_end && Carbon::now('Asia/Kolkata')->greaterThan(Carbon::parse($job->auction_end)))
        ) {
            return response()->json([
                'status'  => 'error',
                'message' => 'This auction has ended. No more bids are accepted.'
            ], 422);
        }

        $minBidInDb = JobBid::where('job_post_id', $job->id)->min('amount');

        if (!$minBidInDb) {
            $maxAllowed = ($job->budget > 0) ? $job->budget : 1000000;
            $errorMsg   = "Your bid must be ₹" . number_format($maxAllowed) . " or lower.";
        } else {
            $maxAllowed = $minBidInDb - 500;
            $errorMsg   = "Your bid must be ₹" . number_format($maxAllowed) . " or lower (Min. ₹500 drop required).";
        }

        $request->validate([
            'job_id'     => 'required|exists:job_posts,id',
            'amount'     => 'required|numeric|min:1|max:' . $maxAllowed,
            'message'    => 'nullable|string|max:500',
            'attachment' => 'nullable|mimes:pdf|max:2048',
        ], [
            'amount.max' => $errorMsg
        ]);

        $previousLowestBid = JobBid::where('job_post_id', $job->id)
            ->where('vendor_id', '!=', $vendorId)
            ->orderBy('amount', 'asc')
            ->first();

        $fileName = null;
        if ($request->hasFile('attachment')) {
            $destinationPath = public_path('uploads/bids');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }
            $fileName = time() . '_' . $request->file('attachment')->getClientOriginalName();
            $request->file('attachment')->move($destinationPath, $fileName);
        }

        $existingBid = JobBid::where('job_post_id', $request->job_id)
            ->where('vendor_id', $vendorId)
            ->first();

        $bidData = JobBid::updateOrCreate(
            ['job_post_id' => $request->job_id, 'vendor_id' => $vendorId],
            [
                'amount'     => $request->amount,
                'message'    => $request->message ?? ($existingBid->message ?? null),
                'attachment' => $fileName ?? ($existingBid->attachment ?? null),
                'status'     => 'pending',
                'created_at' => Carbon::now('Asia/Kolkata'),
                'updated_at' => Carbon::now('Asia/Kolkata'),
            ]
        );

        if (
            $previousLowestBid &&
            $previousLowestBid->vendor_id !== $vendorId &&
            (int) $request->amount < (int) $previousLowestBid->amount
        ) {
            try {
                $previousLowestBidder = User::find($previousLowestBid->vendor_id);
                if ($previousLowestBidder) {
                    $previousLowestBidder->notify(new BidOutbidNotification(
                        $job->title,
                        (float) $request->amount,
                        $job->id
                    ));
                }
            } catch (\Exception $e) {
                \Log::error('BidOutbidNotification Error: ' . $e->getMessage());
            }
        }

        try {
            $bidData->load('vendor:id,name');
            broadcast(new BidPlaced($bidData))->toOthers();
        } catch (\Exception $e) {
            \Log::error('Pusher/Reverb Broadcast Error: ' . $e->getMessage());
        }

        return response()->json([
            'status'         => 'success',
            'message'        => 'Bid placed successfully!',
            'current_lowest' => (int) $request->amount
        ]);
    }

    // ── Get Bid Status (Live) ─────────────────────────────────────────────────
    public function getBidStatus($job_id)
    {
        $job = JobPost::findOrFail($job_id);

        $lowestBid     = JobBid::where('job_post_id', $job_id)->min('amount');
        $displayLowest = $lowestBid ?? $job->budget;

        $history = JobBid::where('job_post_id', $job_id)
            ->with('vendor:id,name')
            ->orderBy('amount', 'asc')
            ->take(10)
            ->get()
            ->map(function ($bid) {
                $secondsAgo = $bid->created_at->diffInSeconds(Carbon::now('Asia/Kolkata'));
                return [
                    'amount'      => (int) $bid->amount,
                    'vendor_id'   => $bid->vendor_id,
                    'vendor_name' => $bid->vendor->name ?? 'Vendor',
                    'time'        => ($secondsAgo < 60) ? 'Just now' : $bid->created_at->diffForHumans(),
                ];
            });

        return response()->json([
            'lowest'      => (int) $displayLowest,
            'auction_end' => $job->auction_end,
            'history'     => $history
        ]);
    }

    // ── Index — Manage Bids (DataTable) ───────────────────────────────────────
    public function index(Request $request)
    {
        $userId = Auth::id();

        if ($request->ajax()) {
            $bids = JobBid::with(['jobPost' => function($q) {
                    $q->withTrashed()->with('categories');
                }])
                ->where('vendor_id', $userId)
                ->latest()
                ->get();

            return DataTables::of($bids)
                ->addIndexColumn()
                ->addColumn('job_id', fn($r) => $r->jobPost
                    ? '<span class="text-primary fw-bold">EL#' . str_pad($r->jobPost->id, 5, '0', STR_PAD_LEFT) . '</span>'
                    : '—')
                ->addColumn('job_title', fn($r) => $r->jobPost
                    ? '<strong>' . e($r->jobPost->title) . '</strong><br>
                       <small class="text-muted">' . e($r->jobPost->city ?? $r->jobPost->location ?? '') . '</small>'
                    : '<span class="text-danger small">Job Deleted</span>')
                ->addColumn('my_bid', function($r) {
                    $lowest = JobBid::where('job_post_id', $r->job_post_id)->min('amount');
                    $badge  = ($r->amount == $lowest)
                        ? ' <span class="badge bg-success" style="font-size:10px;">Lowest</span>'
                        : '';
                    return '<strong>₹' . number_format($r->amount, 2) . '</strong>' . $badge;
                })
                ->addColumn('lowest_bid', fn($r) =>
                    '₹' . number_format(
                        JobBid::where('job_post_id', $r->job_post_id)->min('amount') ?? 0, 2
                    )
                )
                ->addColumn('auction_status', function($r) {
                    if (!$r->jobPost) return '—';
                    return match($r->jobPost->auction_status) {
                        'live'   => '<span class="badge bg-success">● Live</span>',
                        'closed' => '<span class="badge bg-secondary">Closed</span>',
                        default  => '<span class="badge bg-warning text-dark">Pending</span>',
                    };
                })
                ->addColumn('result', function($r) {
                    if (!$r->jobPost) return '—';
                    $status   = $r->jobPost->getRawOriginal('status');
                    $isWinner = $r->jobPost->assigned_to == Auth::id();
                    return match(true) {
                        $status === 'assigned' && $isWinner  => '<span class="badge bg-success">🏆 Won</span>',
                        $status === 'assigned' && !$isWinner => '<span class="badge bg-secondary">Not Selected</span>',
                        $status === 'completed' && $isWinner => '<span class="badge bg-primary">✅ Completed</span>',
                        default => '<span class="badge bg-warning text-dark">Active</span>',
                    };
                })
                ->addColumn('action', fn($r) =>
                    '<a href="' . route('service-provider.bid-show', $r->id) . '"
                        class="btn btn-sm btn-light border">
                        <i class="bi bi-eye text-primary"></i>
                     </a>'
                )
                ->rawColumns(['job_id', 'job_title', 'my_bid', 'auction_status', 'result', 'action'])
                ->make(true);
        }

        return view('service-provider-panel.manage-bids.index');
    }

    // ── Show — Single Bid Detail ──────────────────────────────────────────────
    public function show($id)
    {
        $bid = JobBid::with(['jobPost' => function($q) {
                $q->withTrashed()->with('categories');
            }])
            ->where('vendor_id', Auth::id())
            ->findOrFail($id);

        return view('service-provider-panel.manage-bids.show', compact('bid'));
    }
}