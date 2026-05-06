<?php

namespace App\Http\Controllers\Admins;

use App\Enums\UserSubscriptionStatus;
use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BillingSubscriptionsController extends Controller
{
    public function index(Request $request)

    
    {
        if(!canAccessModule('billing'))
            return abort(404);

        if($request->ajax()){
            $subscriptions = UserSubscription::query();
            $subscriptions = $subscriptions->with(['user','plan']);
            $subscriptions = $subscriptions->get();
            return DataTables::of($subscriptions)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    return view('admin-panel.billings.subscriptions._partials._status', ['subscription' => $row])->render();
                })
                ->addColumn('action', function ($row) {
                    return view('admin-panel.billings.subscriptions._partials._actions', ['subscription' => $row])->render();
                })
                ->rawColumns(['status','action'])

                ->make(true);
        }

        //Subscriptions Status and Counts
        $filters = [];
        foreach (UserSubscriptionStatus::cases() as $subscriptionStatus){
            $filters[$subscriptionStatus->value] = UserSubscription::whereIn('status',[$subscriptionStatus->value])->whereDate('end_date','>=',Carbon::today())->count();
        }
        //For Expired Counts
        $filters['expired'] = UserSubscription::whereDate('end_date','<',Carbon::today())->count();
        return view('admin-panel.billings.subscriptions.index',compact('filters'));
    }

    public function show(Request $request, User $serviceprovider)
    {

        return view('admin-panel.billings.subscriptions.show',['provider'=>$serviceprovider,'profile'=>$serviceprovider->serviceproviderprofile() ? $serviceprovider->serviceproviderprofile()->first() : null]);
    }
}
