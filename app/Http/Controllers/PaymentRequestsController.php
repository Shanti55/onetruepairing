<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use App\Models\Payment;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentRequestsController extends Controller
{
    public function __invoke(Request $request)
    {

        $data = $request->except('attachment');
        $subscriptionPlan  = SubscriptionPlan::find($data['subscription_plan_id']);
        $user = \App\Models\User::find($data['user_id']);

        $todayDate = Carbon::now();
        $amount = 0;
        if($data['billing_cycle'] == 'monthly'){
            $amount = $subscriptionPlan->price;
            $endDate = $todayDate->clone()->addMonths(1)->toDateString();
        }else{
            $amount = $subscriptionPlan->yearly_price;
            $endDate = $todayDate->clone()->addMonths(12)->toDateString();
        }

        $data['features'] = $subscriptionPlan->features;
        $data['start_date'] = $todayDate->clone()->toDateString();
        $data['end_date'] = $endDate;
        $data['status'] = 'pending';
        $data['next_billing_date'] = $data['end_date'];
        $plan = UserSubscription::create($data);
        $plan = $plan->refresh();
        //make subscription as current
        markPlanAsCurrent($user,$plan);

        //If Attachment
        if ($request->hasFile('attachment')) {
            $attachment = $request->attachment;
            $attachmentName = time() . '_' . uniqid() . '.' . $attachment->getClientOriginalExtension();
            // Move the image to the public/images directory
            $attachment->move(public_path('payments'), $attachmentName);
            // Store the URL
            $data['attachment'] = asset('payments/' . $attachmentName);
        }
        //make payment entry
        Payment::create([
            'user_id'=>$user->id,
            'user_subscription_id'=>$plan->id,
            'amount'=>$amount,
            'payment_date'=>Carbon::now()->toDateString(),
            'status'=>'pending',
            'payment_method'=>'qr_code',
            'payment_type'=>'credit',
            'attachment'=>$data['attachment']
        ]);


        return response()->json(['message' => 'Hurray!! Your Account Is Inactive , once approve of payment it will be active']);
    }

}

function markPlanAsCurrent($user,$plan)
{

    $allPlans = UserSubscription::query();
    $allPlans = $allPlans->where('user_id',$user->id)->whereNotIn('id',[$plan->id])->get();
    if(count($allPlans)>0){
        foreach ($allPlans as $p){
            $p->update(['is_current'=>0]);
        }
    }


}
