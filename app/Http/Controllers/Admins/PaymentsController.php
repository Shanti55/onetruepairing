<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PaymentsController extends Controller
{
    public function index(Request $request)
    {
        if(!canAccessModule('billing'))
            return abort(404);

        if($request->ajax()){
            $payments = Payment::with(['user','userSubscription']);
            $payments = $payments->whereNotIn('status',['pending'])->get();

            return DataTables::of($payments)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    return view('admin-panel.billings._partials._status', ['payment' => $row])->render();
                })
                ->addColumn('description', function ($row) {
                    return view('admin-panel.billings._partials._description', ['payment' => $row])->render();
                })
                ->addColumn('attachment', function ($row) {
                    return view('admin-panel.billings._partials._attachment', ['payment' => $row])->render();
                })
//                ->addColumn('action', function ($row) {
//                    return view('admin-panel.billings.payment-requests._partials._actions', ['payment' => $row])->render();
//                })
                ->rawColumns(['status','description','attachment'])

                ->make(true);
        }
        return view('admin-panel.billings.payments.index');
    }

    public function paymentRequest(Request $request){
        if(!canAccessModule('billing'))
            return abort(404);

        if($request->ajax()){
            $payments = Payment::with(['user','userSubscription']);
            $payments = $payments->where('status','pending')->get();

            return DataTables::of($payments)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    return view('admin-panel.billings._partials._status', ['payment' => $row])->render();
                })
                ->addColumn('description', function ($row) {
                    return view('admin-panel.billings._partials._description', ['payment' => $row])->render();
                })
                ->addColumn('attachment', function ($row) {
                    return view('admin-panel.billings.._partials._attachment', ['payment' => $row])->render();
                })
//                ->addColumn('action', function ($row) {
//                    return view('admin-panel.billings.payment-requests._partials._actions', ['payment' => $row])->render();
//                })
                ->rawColumns(['status','description','attachment'])

                ->make(true);
        }

        return view('admin-panel.billings.payment-requests.index');
    }

    public function show(Request $request, User $serviceprovider)
    {

        return view('admin-panel.billings.subscriptions.show',['provider'=>$serviceprovider,'profile'=>$serviceprovider->serviceproviderprofile() ? $serviceprovider->serviceproviderprofile()->first() : null]);
    }
}
