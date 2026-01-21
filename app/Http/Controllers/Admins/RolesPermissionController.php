<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\RolesPermission;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RolesPermissionController extends Controller
{
    public function index(Request $request)
    {
        if(!canAccessModule('roles_permissions'))
            return abort(404);

        if($request->ajax()){
            $roles= RolesPermission::all();

            return DataTables::of($roles)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin-panel.roles-permissions._actions', ['roles' => $row])->render();
                })
                ->rawColumns(['action'])

                ->make(true);
        }
        return view('admin-panel.roles-permissions.index');
    }

    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2'
        ]);
        if($request->id) {
            RolesPermission::find($request->id)->update($request->all());
        } else {
            RolesPermission::create($request->all());
        }

        return response()->json(['message' => 'Roles & Permission Created Successfully!']);
    }

    public function edit(Request $request, RolesPermission $roles)
    {
        return response()->json($roles);
    }

    public function destroy(Request $request, RolesPermission $roles)
    {
        $roles->delete();

        return response()->json(['message' => 'Roles & Permissions Deleted Successfully!']);
    }
}
