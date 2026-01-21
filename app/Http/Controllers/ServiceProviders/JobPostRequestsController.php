<?php

namespace App\Http\Controllers\ServiceProviders;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\JobPost;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;





class JobPostRequestsController extends Controller
{
    public function index(Request $request)
    {

        
        $serviceProviders = User::ofType('service-provider')->get();
        if($request->ajax()){
            $jobs = JobPost::query();
         $jobs = JobPost::whereIn('status', ['verified', 'approved'])
    ->whereIn('is_accepted', ['open', 'pending'])
    ->where('posted_by', '!=', auth()->id())
    ->latest()
    ->get();

       return DataTables::of($jobs)
        ->addIndexColumn()
        ->addColumn('job_id', fn($row) => 'JB-' . $row->id)
        ->addColumn('title', fn($row) =>
            view('service-provider-panel.job-posts.partials._title', ['job' => $row])->render()
        )
        ->addColumn('acceptance', function ($job) {

            $alreadyBid = \App\Models\JobBid::where('job_post_id', $job->id)
                ->where('service_provider_id', auth()->id())
                ->exists();

            if ($alreadyBid) {
                return '<button class="btn btn-sm btn-secondary" disabled>
                            Bid Placed
                        </button>';
            }

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
        return view('service-provider-panel.job-posts.job-requests.index',compact('users','serviceProviders','categories'));

    }

    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'title' => 'required|min:2'
        ]);
        $data = $request->except('categories');
        $job = null;
        if($request->id) {
           $job = JobPost::find($request->id);
           $job->update($data);
           $job->refresh();
        } else {
           $job = JobPost::create($data);
        }
        $job->categories()->sync($request->categories);

        return response()->json(['message' => 'Job Post Created Successfully!']);

    }

    public function edit(Request $request, JobPost $job)
    {
        $categories = $job->categories()->get()->pluck('id');
        return response()->json(['job'=>$job,'categories'=>$categories]);
    }

    public function destroy(Request $request, JobPost $job)
    {
        $job->delete();

        return response()->json(['message' => 'Posted Job Deleted Successfully!']);
    }


}
