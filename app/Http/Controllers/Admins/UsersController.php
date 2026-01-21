<?php

namespace App\Http\Controllers\Admins;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        if(!canAccessModule('users'))
            return abort(404);

        if($request->ajax()){
            $users = User::where('role','user')->with('userprofile');

            if($request->has('name') && !empty($request->name)){

                $users->where('name','LIKE','%'.$request->name.'%');
            }

            if($request->has('contact_number') && !empty($request->contact_number)){
                $users = $users->whereHas('userprofile',function ($query) use ($request){
                    $query->where('contact_number','LIKE','%'.$request->contact_number.'%');
                });
            }

            if($request->has('location') && !empty($request->location)){
                $users = $users->whereHas('userprofile',function ($query) use ($request){
                    $locationArray = explode(", ", $request->location);
                    $query->where(function ($query) use ($locationArray){
                        $query->orWhereIN('pin_code',$locationArray);
                        $query->orWhereIN('city',$locationArray);
                        $query->orWhereIN('state',$locationArray);
                    });
                });

            }

            $users = $users->get();
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($user) {
                    return '<input type="checkbox" class="user-checkbox" value="'.$user->id.'">';
                })
                ->addColumn('action', function ($row) {
                    return view('admin-panel.users._actions', ['user' => $row])->render();
                })
                ->rawColumns(['checkbox','action'])

                ->make(true);
        }

        $usersList = User::where('role','user')->with('userprofile')->get();


        return view('admin-panel.users.index',compact('usersList'));
    }

    public function storeOrUpdate(Request $request)
    {

        if ($request->id) {
            $user = User::find($request->id);

            $request->validate([
                'name' => 'required|min:2',
                'email' => 'nullable|email|unique:users,email,' . $user->id,
            ]);

            if ($request->password) {
                $request->validate(['password' => 'required|confirmed']);
                $request->merge(['password' => Hash::make($request->password)]);
            } else {
                $request->offsetUnset('password');
            }
            $data = $request->except('contact_number');
            $user->update($data);

            if (isset($request->contact_number)) {
                $user->userprofile()->updateOrCreate(
                    ['profileable_type' => User::class, 'profileable_id' => $user->id],
                    ['contact_number' => $request->contact_number]
                );
            }
        } else {
            $request->validate([
                'name' => 'required|min:2',
                'email' => 'required'
            ]);

            $request->merge(["role" => "user"]);
            $request->merge(['password' => Hash::make($request->password)]);
            $data = $request->except('contact_number');
            $user = User::create($data);

            if (isset($request->contact_number)) {
                $user->userprofile()->create([
                    'profileable_type' => User::class,
                    'profileable_id' => $user->id,
                    'contact_number' => $request->contact_number
                ]);
            }
        }

        return response()->json(['message' => 'User Created Successfully!']);
    }


    public function edit(Request $request, User $user)
    {
        $user->load('userprofile');
        return response()->json($user);
    }

    public function destroy(Request $request, User $user)
    {
        $user->delete();

        return response()->json(['message' => 'User Deleted Successfully!']);
    }

    public function bulkDelete(Request $request)
    {
        User::whereIn('id', $request->ids)->delete();
        return response()->json(['message' => 'Users deleted successfully']);
    }

    public function show(Request $request, User $user)
    {
        $profile = $user->userprofile ?? null;

        return view('admin-panel.users.show', compact('user', 'profile'));
    }

    public function export()
    {
        return Excel::download((new UsersExport())->withQuery(request()->all()), 'users.xlsx');
    }

}
