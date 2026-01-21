<?php
namespace App\Http\Controllers\Admins\JobPosts;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use Illuminate\Http\Request;

class JobPostsAssignedToUpdateController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'id'=>'required',
            'assignedTo' => 'required'
        ]);

        $job = JobPost::find($request->id);

        if(isset($job)){
            $job->update(['assigned_to'=>$request->assignedTo]);
        }

        return response()->json(['message' => 'Assignee Updated']);
    }

}
