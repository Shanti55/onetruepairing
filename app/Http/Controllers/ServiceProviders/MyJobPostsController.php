<?php

namespace App\Http\Controllers\ServiceProviders;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\JobPost;
use App\Models\User;
use App\Notifications\ClientJobPostingUpdateToVendor;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MyJobPostsController extends Controller
{
    public function index(Request $request)
    {
        $serviceProviders = User::ofType('service-provider')->get();
        if($request->ajax()){
            $jobs = JobPost::query();
            $jobs = $jobs->where('posted_by',auth()->user()->id)->latest()->get();
            return DataTables::of($jobs)
                ->addIndexColumn()
                ->addColumn('job_id', function ($row) {
                    $job_id = '<span class="text-secondary">JB-'.$row->id.'</span>';
                    return $job_id;
                })
                ->addColumn('title', function ($row) {
                    return view('service-provider-panel.job-posts.my-job-posts._title', ['job' => $row])->render();
                })
                ->addColumn('status', function ($row) {
                    return view('service-provider-panel.job-posts.my-job-posts._status', ['job' => $row])->render();
                })
                ->addColumn('assigned_to', function ($row)use($serviceProviders) {
                    return view('service-provider-panel.job-posts.my-job-posts._assigned', ['job' => $row,'serviceProviders' => $serviceProviders])->render();
                })
                ->addColumn('progress_bar', function ($row) {
                    return view('partials.job-posts._job-progress-bar', ['job' => $row])->render();
                })
                ->addColumn('action', function ($row) {
                    return view('service-provider-panel.job-posts.my-job-posts._actions', ['job' => $row])->render();
                })
                ->rawColumns(['title','job_id','status','assigned_to','progress_bar','action'])

                ->make(true);
        }

        $users = User::all();
        $categories = Category::all();
        return view('service-provider-panel.job-posts.my-job-posts.index',compact('users','serviceProviders','categories'));

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


    public function show(Request $request, JobPost $job,User $serviceprovider)
    {
        return view('admin-panel.job-posts.show',['job'=>$job,'serviceprovider' => $serviceprovider,'profile'=>$serviceprovider->serviceproviderprofile() ? $serviceprovider->serviceproviderprofile()->first() : null]);
    }



}
