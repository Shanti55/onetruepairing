<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use App\Models\User;
use Illuminate\Http\Request;

class InboxController extends Controller
{
    public function getNotifications(Request $request)
    {
        $notifications = auth()->user()->notifications()->latest()->limit(5)->skip($request->skip);

        return response()->json([
            'notifications' => $notifications->get(),
        ]);

    }

    public function getUnReadCount()
    {
        $count = auth()->user()->notifications()->where('read_at',null);
        $count = $count->count();

        return response()->json([
            'count' => $count
        ]);

    }

    public function readNotification(Request $request)
    {
        auth()->user()->notifications()->where('id', $request->id)->first()->markAsRead();
    }
    public function getJobStatus(Request $request)
    {
        $job = JobPost::find($request->job_post_id);
        $user = User::where('id',$job->postedBy->id)->select('name')->first();
        $jobPost = [
            'job_post_id' => $job->id,
            'job_status' => ucwords(str_replace('_',' ',$job->status->value)),
            'job_status_color' => $job->status->color(),
            'userName' => $user->name,
        ];
        return response()->json(['jobPost' => $jobPost]);

    }

    public function getOfflineVerificationStatus(Request $request)
    {
        $user = User::find($request->service_provider_id);
        $serviceProvider = [
            'service_provider_id' => $user->id,
            'offline_verification_status' => ucwords(str_replace('_',' ',$user->offline_verification->value)),
            'offline_verification_status_color' => $user->offline_verification->color(),
            'userName' => $user->name,
        ];
        return response()->json(['serviceProvider' => $serviceProvider]);

    }

}
