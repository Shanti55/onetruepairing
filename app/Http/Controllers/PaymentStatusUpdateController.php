<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use App\Models\Payment;
use App\Notifications\JobStatus;
use Illuminate\Http\Request;

class PaymentStatusUpdateController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'id'=>'required',
            'status' => 'required'
        ]);

        $payment = Payment::find($request->id);

        if(isset($payment)){
            $payment->update(['status'=>$request->status]);
            $payment->refresh();
            if($payment->status->value == 'completed' && isset($payment->userSubscription)){
                $payment->userSubscription->update(['status'=>'active']);
            }

        }
        //Send Notification
        //$job->postedBy->notify(new JobStatus($job));

        return response()->json(['message' => 'Status Updated']);
    }

}
