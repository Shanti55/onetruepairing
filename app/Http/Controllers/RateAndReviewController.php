<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use App\Models\JobPost;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RateAndReviewController extends Controller
{

    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'rating'=>'required',
        ]);

        $job = JobPost::find($request->job_id);

        if($job){
            $job->update($request->except('job_id'));
        }

        return response()->json(['status'=>200]);

    }
}
