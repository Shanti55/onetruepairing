<?php

namespace App\Http\Controllers\Admins\JobPosts;

use App\Http\Controllers\Controller;
use App\Models\JobBid;
use App\Models\JobPost;
use App\Models\User;
use App\Models\Payment;
use App\Notifications\AuctionWinnerNotification;
use App\Notifications\AuctionLoserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Yajra\DataTables\Facades\DataTables;

class JobBiddingController extends Controller
{
    // ── List all jobs with bids ───────────────────────────────────────────
   public function index(Request $request)
{
    if ($request->ajax()) {
        $jobs = JobPost::has('bids')
            ->withCount('bids')
            ->with('bids')
            ->latest()
            ->get();

        return DataTables::of($jobs)
            ->addIndexColumn()
            ->addColumn('total_bids', fn($row) => $row->bids_count . ' bids')
            ->addColumn('lowest_bid', function ($row) {
                $lowest = $row->bids->min('amount');
                return $lowest ? '₹' . number_format($lowest, 2) : '—';
            })
            ->addColumn('status', function ($row) {
                $badge = match($row->status) {
                    'open'     => '<span class="badge bg-success">Live</span>',
                    'closed'   => '<span class="badge bg-secondary">Closed</span>',
                    'assigned' => '<span class="badge bg-primary">Assigned</span>',
                    default    => '<span class="badge bg-warning text-dark">Pending</span>',
                };
                return $badge;
            })
            ->addColumn('action', function ($row) {
                return '<a href="' . route('admin.manage-bids.show', $row->id) . '"
                            class="btn btn-sm btn-primary">
                            <i class="bi bi-eye me-1"></i>View Bids
                        </a>';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    return view('admin-panel.manage-bids.index');
}

    // ── Show bids for a specific job ──────────────────────────────────────
    public function show($id)
    {
        $job  = JobPost::with('bids.vendor')->findOrFail($id);
        $bids = $job->bids()->with('vendor')->orderBy('amount', 'asc')->get();
        return view('admin-panel.manage-bids.show', compact('job', 'bids'));
    }

    // ── Hire a vendor ─────────────────────────────────────────────────────
    public function hire(Request $request)
    {
        $request->validate([
            'job_id'    => 'required|exists:job_posts,id',
            'vendor_id' => 'required|exists:users,id',
        ]);

        $job    = JobPost::findOrFail($request->job_id);
        $winner = User::findOrFail($request->vendor_id);

        // ── 1. Job update ─────────────────────────────────────────────────
        $updateData = [
            'assigned_to' => $winner->id,
            'status'      => 'assigned',
        ];
        if (Schema::hasColumn('job_posts', 'auction_status')) {
            $updateData['auction_status'] = 'closed';
        }
        $job->update($updateData);

        // ── 2. Winning bid amount ─────────────────────────────────────────
        $winningBid = JobBid::where('job_post_id', $job->id)
            ->where('vendor_id', $winner->id)
            ->first();

        // ── 3. Winner ko notification ─────────────────────────────────────
        try {
            $winner->notify(new AuctionWinnerNotification(
                $job->title,
                $winningBid ? (float) $winningBid->amount : 0.0,
                $job->id
            ));
        } catch (\Exception $e) {
            \Log::error('Winner notification error: ' . $e->getMessage());
        }

        // ── 4. Losers ko notification ─────────────────────────────────────
        $loserBids = JobBid::where('job_post_id', $job->id)
            ->where('vendor_id', '!=', $winner->id)
            ->with('vendor')
            ->get();

        foreach ($loserBids as $bid) {
            if ($bid->vendor) {
                try {
                    $bid->vendor->notify(new AuctionLoserNotification(
                        $job->title,
                        $winner->name,
                        $job->id
                    ));
                } catch (\Exception $e) {
                    \Log::error('Loser notification error for vendor ' . $bid->vendor_id . ': ' . $e->getMessage());
                }
            }
        }

        // ── 5. Payment refund status update ───────────────────────────────
        Payment::where('job_id', $job->id)
            ->where('user_id', $winner->id)
            ->where('payment_for', 'job_registration')
            ->update(['refund_status' => 'not_applicable']);

        Payment::where('job_id', $job->id)
            ->where('user_id', '!=', $winner->id)
            ->where('payment_for', 'job_registration')
            ->where('status', 'complete')
            ->update(['refund_status' => 'pending']);

        return response()->json([
            'status'  => 'success',
            'message' => "'{$winner->name}' hired! Winner and all participants notified."
        ]);
    }
}