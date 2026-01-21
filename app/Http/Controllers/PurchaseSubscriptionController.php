<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PurchaseSubscriptionController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = $request->all();
        $subscriptionPlan  = SubscriptionPlan::find($data['subscription_plan_id']);
        $user = \App\Models\User::find($data['user_id']);

        $todayDate = Carbon::now();
        $data['features'] = $subscriptionPlan->features;
        $data['start_date'] = isset($request->start_date) ? $request->start_date : $todayDate->clone()->toDateString();
        $data['end_date'] = isset($request->end_date) ? $request->end_date : $todayDate->clone()->addMonths(3)->toDateString();
        $data['next_billing_date'] = $data['end_date'];
        $plan = UserSubscription::create($data);
        $plan = $plan->refresh();
        markPlanAsCurrent($user,$plan);


        return response()->json(['message' => 'Hurray!! Your Trial Account Is Active']);
    }

}
