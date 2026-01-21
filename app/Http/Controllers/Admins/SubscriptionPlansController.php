<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SubscriptionPlansController extends Controller
{
    public function index(Request $request)
    {

        if(!canAccessModule('subscription_plan'))
            return abort(404);

        if($request->ajax()){
            $plans = SubscriptionPlan::all();

            return DataTables::of($plans)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    return view('admin-panel.subscription-plans._status', ['plan' => $row])->render();
                })
                ->addColumn('features', function ($row) {
                    return view('admin-panel.subscription-plans.partials._features', ['plan' => $row])->render();
                })
                ->addColumn('action', function ($row) {
                    return view('admin-panel.subscription-plans._actions', ['plan' => $row])->render();
                })
                ->rawColumns(['status','features','action'])

                ->make(true);
        }

        return view('admin-panel.subscription-plans.index');
    }

    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2'
        ]);

        $request['features'] = json_encode($request->features);
        if($request->id) {
            SubscriptionPlan::find($request->id)->update($request->all());
        } else {
            SubscriptionPlan::create($request->all());
        }

        return response()->json(['message' => 'Subscription Plan Created Successfully!']);

    }

    public function edit(Request $request, SubscriptionPlan $plan)
    {
        return response()->json($plan);
    }

    public function destroy(Request $request, SubscriptionPlan $plan)
    {
        $plan->delete();

        return response()->json(['message' => 'Subscription Plan Deleted Successfully!']);
    }
}
