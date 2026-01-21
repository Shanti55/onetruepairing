<?php
namespace App\Http\Controllers\ServiceProviders;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\JobPost;
use App\Notifications\ClientJobApplicationReceived;
use App\Notifications\VendorJobApplicationConfirmation;
use Illuminate\Http\Request;

class JobPostsAcceptanceController extends Controller
{
   public function __invoke(Request $request)
{
    $request->validate([
        'id'=>'required',
        'acceptance' => 'required',
    ]);

    $job = JobPost::where('is_accepted','open')
                ->where('id',$request->id)
                ->first();

    if(!$job){
        return response()->json(['message' => 'Sorry!! Job is not available']);
    }

    if($job->posted_by == auth()->id()){
        return response()->json(['message' => 'Sorry!! You cannot do action on this job']);
    }

    // ❌ ACCEPT JOB DISABLED (FOR BIDDING SYSTEM)
    if($request->acceptance == 'accept'){
        return response()->json([
            'message' => 'Direct accept disabled. Please place a bid.'
        ]);
    }

    // ❌ DECLINE LOGIC (OPTIONAL – KEEP OR REMOVE)
    if($request->acceptance == 'decline'){
        $declineList = [];

        if($job->declined_by){
            $declineList = json_decode($job->declined_by, true);
        }

        $declineList[] = auth()->id();

        $job->update([
            'declined_by' => json_encode($declineList)
        ]);
    }

    return response()->json(['message' => 'Action completed']);
}
}