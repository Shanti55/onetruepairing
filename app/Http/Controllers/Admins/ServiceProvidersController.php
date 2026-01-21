<?php

namespace App\Http\Controllers\Admins;

use App\Exports\ServiceProviderExport;
use App\Http\Controllers\Controller;
use App\Imports\ServiceProviderImporter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ServiceProvidersController extends Controller
{
    public function index(Request $request)
    {
        if(!canAccessModule('service_providers'))
            return abort(404);

        if($request->ajax()){
            $serviceproviders = User::where('role','service-provider')
                ->with(['serviceproviderprofile:id,profileable_id,company_name,contact_number,city,state'])
                ->select('id','name','email','offline_verification','status');

            if($request->has('name') && !empty($request->name)){
                $serviceproviders->where('name','LIKE','%'.$request->name.'%');
            }

            if($request->has('company_name') && !empty($request->company_name)){
                $serviceproviders = $serviceproviders->whereHas('serviceproviderprofile',function ($query) use ($request){
                        $query->where('company_name','LIKE','%'.$request->company_name.'%');
                        if($request->has('contact_number') && !empty($request->contact_number)){
                            $query->where('contact_number','LIKE','%'.$request->contact_number.'%');
                        }
                        if($request->has('location') && !empty($request->location)){
                            $locationArray = explode(", ", $request->location);
                            $query->where(function ($query) use ($locationArray){
                                $query->orWhereIN('pin_code',$locationArray);
                                $query->orWhereIN('city',$locationArray);
                                $query->orWhereIN('state',$locationArray);
                            });
                        }

                });
            }


            $serviceproviders = $serviceproviders->get();
            return DataTables::of($serviceproviders)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($user) {
                    return '<input type="checkbox" class="user-checkbox" value="'.$user->id.'">';
                })
                ->addColumn('offline_verification', function ($row) {
                    return view('admin-panel.serviceproviders._offline-verification', ['serviceprovider' => $row])->render();
                })
                ->addColumn('status', function ($row) {
                    return view('admin-panel.serviceproviders._status', ['serviceprovider' => $row])->render();
                })
                ->addColumn('action', function ($row) {
                    return view('admin-panel.serviceproviders._actions', ['serviceprovider' => $row])->render();
                })
                ->rawColumns(['checkbox','offline_verification','status','action'])

                ->make(true);
        }

        $serviceProvidersList = User::where('role','service-provider')->with('serviceproviderprofile')->get();


        return view('admin-panel.serviceproviders.index',compact('serviceProvidersList'));
    }

    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2',
            'email' => 'email'
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
            $request->merge(["role"=>"service-provider","created_by"=>auth()->user()->id]);
            $request->password = Hash::make($request->password);
            User::create($request->all());
        }

        return response()->json(['message' => 'Service Provider Created Successfully!']);

    }

    public function edit(Request $request, User $serviceprovider)
    {
        return response()->json($serviceprovider);
    }

    public function update(Request $request, User $serviceprovider)
    {

        return view('admin-panel.serviceproviders.update',['provider'=>$serviceprovider,'profile'=>$serviceprovider->serviceproviderprofile() ? $serviceprovider->serviceproviderprofile()->first() : null]);
    }

    public function show(Request $request, User $serviceprovider)
    {

        return view('admin-panel.serviceproviders.show',['provider'=>$serviceprovider,'profile'=>$serviceprovider->serviceproviderprofile() ? $serviceprovider->serviceproviderprofile()->first() : null]);
    }

    public function billing(Request $request, User $serviceprovider)
    {

        return view('admin-panel.serviceproviders.billing',['provider'=>$serviceprovider,'profile'=>$serviceprovider->serviceproviderprofile() ? $serviceprovider->serviceproviderprofile()->first() : null]);
    }

    public function destroy(Request $request, User $serviceprovider)
    {
        $serviceprovider->delete();
        return response()->json(['message' => 'Service Provider Deleted Successfully!']);
    }

    public function bulkDelete(Request $request)
    {
        User::whereIn('id', $request->ids)->delete();
        return response()->json(['message' => 'Servicer Providers deleted successfully']);
    }

    public function export()
    {
        return Excel::download((new ServiceProviderExport())->withQuery(request()->all()), 'service-providers.xlsx');
    }

    public function import(Request $request)
    {

        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        // Check if the file is properly uploaded

        if ($request->hasFile('file')) {

            $file = $request->file('file');
//            $filePath = $file->store('temp'); // Persist file
//            $fullPath = storage_path('app/' . $filePath); // Full path
//            dd($fullPath);
            Excel::import(new ServiceProviderImporter,$file);
            return back()->with('success', 'Service Providers Imported Successfully');

        }

        return back()->with('success', 'Service Providers Imported Successfully');
    }


}
