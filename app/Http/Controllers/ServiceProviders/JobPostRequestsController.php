<?php

namespace App\Http\Controllers\ServiceProviders;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\JobPost;
use App\Models\User;
use App\Models\JobBid;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class JobPostRequestsController extends Controller
{
   public function index(Request $request)
{
    $serviceProviders = User::ofType('service-provider')->get();

    if($request->ajax()){
        $query = JobPost::where('status', 'verified')
            ->where('posted_by', '!=', auth()->id());

        // FILTER: Agar URL mein job_id hai toh sirf wahi dikhao
        if ($request->has('job_id') && !empty($request->job_id)) {
            $query->where('id', $request->job_id);
        }

        $jobs = $query->latest()->get();

        return DataTables::of($jobs)
            ->addIndexColumn()
            // 🛠 YAHAN HAI VO DYNAMIC FORMAT LOGIC
            ->editColumn('job_id', function($row) {
                $title = $row->title;
                
                // Prefix logic: Pehla letter + Agla Consonant
                $firstLetter = substr($title, 0, 1);
                $remaining = substr($title, 1);
                $consonantsOnly = preg_replace('/[aeiou\s]/i', '', $remaining);
                $secondLetter = substr($consonantsOnly, 0, 1) ?: (substr($title, 1, 1) ?: 'X');
                
                $prefix = strtoupper($firstLetter . $secondLetter);
                $sequence = str_pad($row->id, 5, '0', STR_PAD_LEFT);

                return $prefix . '#' . $sequence; // Output: RS#00006
            })
            ->addColumn('title', function($row) {
                return view('service-provider-panel.job-posts.partials._title', ['job' => $row])->render();
            })
            ->addColumn('acceptance', function ($job) {
                $alreadyBid = JobBid::where('job_post_id', $job->id)
                    ->where('service_provider_id', auth()->id())
                    ->exists();

                if ($alreadyBid) {
                    return '<button class="btn btn-sm btn-secondary" disabled>Bid Placed</button>';
                }

                // data-job-id mein hamesha numeric ID hi rakhein (e.g. 6)
                return '<button class="btn btn-sm btn-primary placeBidBtn" 
                                data-job-id="'.$job->id.'">
                                Place Bid
                            </button>';
            })
            ->rawColumns(['title', 'acceptance'])
            ->make(true);
    }

    $users = User::all();
    $categories = Category::all();
    return view('service-provider-panel.job-posts.job-requests.index', compact('users','serviceProviders','categories'));
}

    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'title' => 'required|min:2'
        ]);
        
        $data = $request->except('categories');
        
        if($request->id) {
           $job = JobPost::find($request->id);
           $job->update($data);
           $job->refresh();
        } else {
           $job = JobPost::create($data);
        }
        
        if($request->has('categories')){
            $job->categories()->sync($request->categories);
        }

        return response()->json(['message' => 'Job Post Updated Successfully!']);
    }

    public function edit(Request $request, JobPost $job)
    {
        $categories = $job->categories()->get()->pluck('id');
        return response()->json(['job'=>$job, 'categories'=>$categories]);
    }

    public function destroy(Request $request, JobPost $job)
    {
        $job->delete();
        return response()->json(['message' => 'Posted Job Deleted Successfully!']);
    }
}