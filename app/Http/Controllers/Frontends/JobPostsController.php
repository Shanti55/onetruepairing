<?php

namespace App\Http\Controllers\Frontends;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\JobPost;
use App\Models\Service;
use App\Models\User;
use App\Notifications\ClientJobPostingUpdateToVendor;
use App\Notifications\JobPostedByClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Exception;
use Yajra\DataTables\Facades\DataTables;

class JobPostsController extends Controller
{

    public function createOrUpdate(Request $request)
    {
        $categories = Category::all();
        $services = Service::all();
        return view('frontend.jobs.job-posts.createOrUpdate',compact('categories','services'));
    }

    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'title' => 'required|min:2'
        ]);

        $data = $request->except('categories');
        $data['posted_by'] = auth()->user()->id;
        $job = null;

        if($request->id) {
            $job = JobPost::find($request->id);
            $job->update($data);
            $job->refresh();
            $job->categories()->sync($request->categories);
        } else {

            $job = JobPost::create($data);
            auth()->user()->notify(new JobPostedByClient($job));
            $job->categories()->sync($request->categories);
        }


        return response()->json(['message' => 'Job Post Created Successfully!']);

    }


}
