<?php

namespace App\Http\Controllers\Admins\JobPosts;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\JobPost;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class JobPostsController extends Controller
{
    public function index(Request $request)
    {
        if (!canAccessModule('jobs')) {
            return abort(404);
        }

        $serviceProviders = User::has('serviceproviderprofile')
            ->with('serviceproviderprofile')
            ->where('role', 'service-provider')
            ->where('status', 'verified')
            ->activeSubscription()
            ->get();

        if ($request->ajax()) {
            $query  = JobPost::query()->latest();
            $status = $request->get('filter_status');

            if ($status) {
                switch ($status) {

                    // ✅ Upcoming — auction scheduled but not started yet
                    case 'upcoming':
                        $query->where('auction_status', 'pending');
                        break;

                    // ✅ Live — open AND auction_end has NOT passed yet
                    case 'live':
                        $query->where('auction_status', 'open')
                              ->where('auction_end', '>', now());
                        break;

                    // ✅ Under Verification — closed, not yet assigned
                    case 'under_verification':
                        $query->where('auction_status', 'closed')
                              ->whereNull('assigned_to')
                              ->where('status', 'under verification');
                        break;

                    // ✅ Closed / Hired — assigned to someone
                    case 'closed':
                        $query->where('auction_status', 'closed')
                              ->whereNotNull('assigned_to')
                              ->where('status', 'assigned');
                        break;
                }
            }

            $jobs = $query->get();

            return DataTables::of($jobs)
                ->addIndexColumn()
                ->addColumn('job_id', function ($row) {
                    return '<span class="text-secondary">EL#' . str_pad($row->id, 5, '0', STR_PAD_LEFT) . '</span>';
                })
                ->addColumn('title', function ($row) {
                    return view('admin-panel.job-posts._title', ['job' => $row])->render();
                })
                ->addColumn('auction_timing', function ($row) {
                    if (!$row->auction_start) {
                        return '<span class="badge bg-light text-dark border">Not Scheduled</span>';
                    }
                    return '<div class="small">
                                <span class="text-success"><b>Start:</b> ' . date('d M, h:i A', strtotime($row->auction_start)) . '</span><br>
                                <span class="text-danger"><b>End:</b> ' . date('d M, h:i A', strtotime($row->auction_end)) . '</span>
                            </div>';
                })
                ->addColumn('status', function ($row) {
                    return view('admin-panel.job-posts._status', ['job' => $row])->render();
                })
                ->addColumn('assigned_to', function ($row) use ($serviceProviders) {
                    return view('admin-panel.job-posts._assigned', ['job' => $row, 'serviceProviders' => $serviceProviders])->render();
                })
                ->addColumn('progress_bar', function ($row) {
                    return view('partials.job-posts._job-progress-bar', ['job' => $row])->render();
                })
                ->addColumn('action', function ($row) {
                    return view('admin-panel.job-posts._actions', ['job' => $row])->render();
                })
                ->rawColumns(['title', 'job_id', 'status', 'assigned_to', 'progress_bar', 'action', 'auction_timing'])
                ->make(true);
        }

        $users      = User::all();
        $categories = Category::all();

        return view('admin-panel.job-posts.index', compact('users', 'serviceProviders', 'categories'));
    }

    public function makeAuctionLive(Request $request)
    {
        $isExtend = filter_var($request->is_extend, FILTER_VALIDATE_BOOLEAN);

        $validator = Validator::make($request->all(), [
            'id'     => 'required|exists:job_posts,id',
            'status' => 'required|in:pending,open,closed',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        $job = JobPost::findOrFail($request->id);

        if ($isExtend) {
            $currentEnd = $job->auction_end ? Carbon::parse($job->auction_end) : Carbon::now();
            $endDate    = $currentEnd->addDays((int) ($request->extend_days ?? 1));
            $startDate  = $job->auction_start ?? Carbon::now();
        } else {
            if (!$request->auction_start || !$request->auction_end) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Please select both start and end dates.',
                ], 422);
            }
            $startDate = Carbon::parse($request->auction_start)->toDateTimeString();
            $endDate   = Carbon::parse($request->auction_end)->toDateTimeString();
        }

        if ($request->status === 'closed') {
            $job->update([
                'auction_start'  => $startDate,
                'auction_end'    => $endDate,
                'auction_status' => 'closed',
                'status'         => 'under verification',
            ]);
            $message = 'Auction closed. Moved to Under Verification.';
        } else {
            $job->update([
                'auction_start'  => $startDate,
                'auction_end'    => $endDate,
                'auction_status' => $request->status,
                'status'         => $request->status,
            ]);
            $message = 'Auction updated to ' . ucfirst($request->status) . '!';
        }

        return response()->json(['status' => 'success', 'message' => $message]);
    }

    public function updateStatus(Request $request)
    {
        $job = JobPost::findOrFail($request->id);
        $job->update(['status' => $request->status]);
        return response()->json(['message' => 'Status Updated!']);
    }

    public function assignWinner(Request $request)
    {
        $request->validate([
            'job_id'    => 'required|exists:job_posts,id',
            'vendor_id' => 'required|exists:users,id',
        ]);

        $job = JobPost::findOrFail($request->job_id);
        $job->update([
            'assigned_to'    => $request->vendor_id,
            'auction_status' => 'closed',
            'status'         => 'assigned',
        ]);

        Payment::where('job_id', $job->id)
            ->where('user_id', $request->vendor_id)
            ->where('payment_for', 'job_registration')
            ->update(['refund_status' => 'not_applicable']);

        Payment::where('job_id', $job->id)
            ->where('user_id', '!=', $request->vendor_id)
            ->where('payment_for', 'job_registration')
            ->where('status', 'complete')
            ->update(['refund_status' => 'pending']);

        return response()->json(['status' => 'success', 'message' => 'Winner assigned successfully!']);
    }

    public function destroy($id)
    {
        $job = JobPost::findOrFail($id);
        $job->delete();
        return response()->json(['status' => 'success', 'message' => 'Job moved to trash.']);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        JobPost::whereIn('id', $ids)->delete();
        return response()->json(['status' => 'success', 'message' => count($ids) . ' jobs moved to trash.']);
    }

    public function restore($id)
    {
        JobPost::onlyTrashed()->findOrFail($id)->restore();
        return response()->json(['status' => 'success', 'message' => 'Job restored.']);
    }

    public function forceDelete($id)
    {
        JobPost::onlyTrashed()->findOrFail($id)->forceDelete();
        return response()->json(['status' => 'success', 'message' => 'Job permanently deleted.']);
    }

    public function trash(Request $request)
    {
        if ($request->ajax()) {
            $jobs = JobPost::onlyTrashed()->latest('deleted_at')->get();
            return DataTables::of($jobs)
                ->addIndexColumn()
                ->addColumn('job_id', fn ($r) => 'EL#' . str_pad($r->id, 5, '0', STR_PAD_LEFT))
                ->addColumn('deleted_at', fn ($r) => $r->deleted_at->diffForHumans())
                ->addColumn('action', function ($r) {
                    return '
                        <button class="btn btn-sm btn-success restore-btn" data-id="' . $r->id . '">
                            <i class="bi bi-arrow-counterclockwise me-1"></i>Restore
                        </button>
                        <button class="btn btn-sm btn-danger force-delete-btn ms-1" data-id="' . $r->id . '">
                            <i class="bi bi-trash3 me-1"></i>Delete Forever
                        </button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin-panel.job-posts.trash');
    }

    public function storeOrUpdate(Request $request)
    {
        $request->validate(['title' => 'required|min:2']);
        $data = $request->except('categories');

        if ($request->id) {
            $job = JobPost::find($request->id);
            $job->update($data);
            $job->refresh();
        } else {
            $job = JobPost::create($data);
        }

        $job->categories()->sync($request->categories);
        return response()->json(['message' => 'Job Saved Successfully!']);
    }

    public function edit(Request $request, JobPost $job)
    {
        $categories = $job->categories()->get()->pluck('id');
        return response()->json(['job' => $job, 'categories' => $categories]);
    }

    public function show(Request $request, JobPost $job, User $serviceprovider)
    {
        return view('admin-panel.job-posts.show', [
            'job'             => $job,
            'serviceprovider' => $serviceprovider,
            'profile'         => $serviceprovider->serviceproviderprofile()
                ? $serviceprovider->serviceproviderprofile()->first()
                : null,
        ]);
    }

    public function auctionRoom()
    {
        $registrations = \App\Models\Payment::with(['user', 'job'])
            ->where('payment_for', 'job_registration')
            ->latest()
            ->get();

        return view('admin-panel.job-posts.auction_room', compact('registrations'));
    }

    public function approveRegistration($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update(['status' => 'complete']);
        return response()->json(['status' => 'success', 'message' => 'Registration approved!']);
    }

    public function rejectRegistration($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update(['status' => 'rejected', 'refund_status' => 'pending']);
        return response()->json(['status' => 'success', 'message' => 'Registration rejected!']);
    }
}