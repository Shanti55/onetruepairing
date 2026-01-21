<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\JobPost;
use App\Models\JobProgress;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class JobProgressController extends Controller
{

    public function index(Request $request)
    {
        if($request->ajax()){
            $jobsProgress = JobProgress::query();
            if($request->has('job_id')){
                $jobsProgress = $jobsProgress->where('job_post_id',$request->job_id);
            }

            return DataTables::of($jobsProgress)
                ->addIndexColumn()
//                ->addColumn('details', function ($row) {
//                    return view('partials.job-posts._job-progress-detail', ['job' => $row])->render();
//                })
                ->addColumn('action', function ($row) {
                    return view('service-provider-panel.job-posts.my-jobs.partials._actions', ['jobProgress' => $row])->render();
                })
                ->rawColumns(['action'])

                ->make(true);
        }

        return view('service-provider-panel.job-posts.my-jobs.show');
    }

    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'progress_value'=>'required',
        ]);

        $data = $request->all();

        if($request->id) {
            JobProgress::find($request->id)->update($data);
        } else {
            JobProgress::create($data);
        }

        return response()->json(['message' => 'Progress Successfully!']);

    }

    public function edit(Request $request, JobProgress $jobProgress)
    {
        return response()->json($jobProgress);
    }

    public function destroy(Request $request, JobProgress $jobProgress)
    {
        $jobProgress->delete();
        return response()->json(['message' => 'Progress Deleted Successfully!']);
    }
}
