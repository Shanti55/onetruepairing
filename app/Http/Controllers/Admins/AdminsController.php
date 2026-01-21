<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class AdminsController extends Controller
{
    public function index(Request $request)
    {
        if(!canAccessModule('admins'))
            return abort(404);

        if($request->ajax()){
            $admins = User::where('role','admin')->with('role_permission');

            if(!auth()->user()->is_master){
                $admins->where('is_master' , 0);
            }

            $admins =  $admins->get();

            return DataTables::of($admins)
                ->addIndexColumn()
                ->addColumn('referral_code', function ($row) {
                    return view('admin-panel.admins._referral_code', ['admin' => $row])->render();
                })
                ->addColumn('provider_counts', function ($row) {
                    return view('admin-panel.admins._provider-counts', ['admin' => $row])->render();
                })
                ->addColumn('action', function ($row) {
                    return view('admin-panel.admins._actions', ['admin' => $row])->render();
                })
                ->rawColumns(['referral_code','provider_counts','action'])

                ->make(true);
        }

        return view('admin-panel.admins.index');
    }

    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2',
            'email' => 'email',
            'primary_mobile_number' => 'required'
        ]);

        if($request->id) {
            if($request->password){
                $request->validate(['password' => 'required|confirmed']);
                $request->password = Hash::make($request->password);
            }else{
                $request->offsetUnset('password');
            }
            User::find($request->id)->update($request->all());
        } else {
            //Generate Referral Code
            $request->merge(["role"=>"admin","referral_code"=>generateReferralCode()]);
            $request->password = Hash::make($request->password);
            User::create($request->all());
        }

        return response()->json(['message' => 'Admin Created Successfully!']);

    }

    public function edit(Request $request, User $admin)
    {
        return response()->json($admin);
    }

    public function destroy(Request $request, User $admin)
    {
        $admin->delete();

        return response()->json(['message' => 'Admin Deleted Successfully!']);
    }
}
