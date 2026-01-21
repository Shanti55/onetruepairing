<?php

namespace App\Http\Controllers\Admins\JobPosts;

use App\Http\Controllers\Controller;
use App\Models\JobPost;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class JobBiddingController extends Controller
{
    public function index(Request $request)
    {
        // 1. Pehle data fetch karein taaki dono cases (Ajax aur Normal) mein variable mil sake
        $jobs = JobPost::has('bids')->withCount('bids')->latest()->get();

        if($request->ajax()){
            return DataTables::of($jobs)
                ->addIndexColumn()
                ->addColumn('total_bids', function ($row) {
                    return '<span class="badge bg-info">'.$row->bids_count.' Bids Received</span>';
                })
                ->addColumn('status', function ($row) {
                    return $row->assigned_to ? '<span class="badge bg-success">Assigned</span>' : '<span class="badge bg-warning">Pending</span>';
                })
                ->addColumn('action', function ($row) {
                    // Route name check karein: admin.manage-bids.show ya manage-bids.show
                    return '<a href="'.route('admin.manage-bids.show', $row->id).'" class="btn btn-sm btn-primary">View All Bids</a>';
                })
                ->rawColumns(['total_bids', 'status', 'action'])
                ->make(true);
        }

        return view('admin-panel.job-bidding.index', compact('jobs'));
    }

    public function show($id)
    {
        // Provider profile ke saath load karein
        $job = JobPost::with(['bids.vendor'])->findOrFail($id);
        return view('admin-panel.job-bidding.show', compact('job'));
    }

   public function hire(Request $request)
{
    $job = JobPost::findOrFail($request->job_id);
    
    // Status ko 'assigned' ya 'completed' set karein jo vendor side par match ho
    $job->update([
        'assigned_to' => $request->vendor_id,
        'status' => 'assigned' 
    ]);

    return back()->with('success', 'Vendor hired and status updated!');
}
}