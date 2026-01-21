<?php
namespace App\Http\Controllers\Admins\JobPosts;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use App\Models\User;
use App\Notifications\ClientJobPostingConfirmation;
use App\Notifications\ClientJobPostingUpdateToVendor;
use App\Notifications\JobStatus;
use Illuminate\Http\Request;

class JobPostsStatusUpdateController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'id'=>'required',
            'status' => 'required'
        ]);

        $job = JobPost::find($request->id);

        if(isset($job)){
           $job->update(['status'=>$request->status]);
        }

        //Send Notification
        try {
            if ($job->status->value == 'verified'){
                $job->load('postedBy');
                $job->postedBy->notify(new ClientJobPostingConfirmation($job));

                \App\Jobs\SendJobNotificationsToVendors::dispatch($job->id);

            }else{
                $job->postedBy->notify(new JobStatus($job));
            }

            //Send Notification to Admin
            $admins = User::where('role','admin')->whereNotIn('id',[auth()->user()->id])->get();
            foreach ($admins as $admin){
                $admin->notify(new JobStatus($job));
            }

        }catch (\Exception $e){

        }


        return response()->json(['message' => 'Status Updated']);
    }

}
