<?php

namespace App\Http\Controllers\Admins\Reports;

use App\Exports\Reports\JobAcceptedDeclinedExport;
use App\Exports\ServiceProviderExport;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class JobAcceptedDeclinedController extends Controller
{
    public function index(Request $request)
    {
        if(!canAccessModule('reports'))
            return abort(404);

        if($request->ajax()){

            $serviceproviders = User::where('role','service-provider')->has('serviceproviderprofile')->with('serviceproviderprofile');

                if($request->has('name') && !empty($request->name)){
                    $serviceproviders->where('name','LIKE','%'.$request->name.'%');
                }

                $serviceproviders = $serviceproviders->whereHas('serviceproviderprofile',function ($query) use ($request){
                    if($request->has('company_name') && !empty($request->company_name)){
                        $query->where('company_name','LIKE','%'.$request->company_name.'%');
                    }
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

                $serviceproviders = $serviceproviders->get();

            return DataTables::of($serviceproviders)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return view('admin-panel.reports.job-accepted-declined.partials._name', ['provider' => $row])->render();
                })
                ->addColumn('accepted', function ($row) {
                    $accepted = "<span class='badge soft-primary'>" . getJobAcceptedCount($row) . "</span>";
                    return $accepted; // Directly return the raw HTML string
                })
                ->addColumn('in_progress', function ($row) {
                    $in_progress = "<span class='badge soft-info'>" . getJobInProgressCount($row) . "</span>";
                    return $in_progress; // Directly return the raw HTML string
                })
                ->addColumn('completed', function ($row) {
                    $completed = "<span class='badge soft-success'>" . getJobCompletedCount($row) . "</span>";
                    return $completed; // Directly return the raw HTML string
                })
                ->addColumn('declined', function ($row) {
                    $declined = "<span class='badge soft-danger'>" . getJobDeclinedCount($row) . "</span>";
                    return $declined; // Directly return the raw HTML string
                })
                ->rawColumns(['name','accepted','in_progress','completed','declined'])
                ->make(true);
        }

        $serviceProvidersList = User::where('role','service-provider')->has('serviceproviderprofile')->with('serviceproviderprofile')->get();

        return view('admin-panel.reports.job-accepted-declined.index',compact('serviceProvidersList','request'));
    }


    public function export()
    {
        return Excel::download((new JobAcceptedDeclinedExport())->withQuery(request()->all()), 'job-accepted-declined-report.xlsx');
    }


}
