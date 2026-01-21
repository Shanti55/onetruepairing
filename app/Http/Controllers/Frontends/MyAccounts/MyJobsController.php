<?php

namespace App\Http\Controllers\Frontends\MyAccounts;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\JobPost;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class MyJobsController extends Controller
{

    public function index(Request $request)
    {

        $jobs = JobPost::query();
        $jobs = $jobs->where('posted_by',auth()->user()->id);
        if($request->has('filter')){
            $jobs = $jobs->where('status',$request->filter);
        }
        $jobs = $jobs->latest()->get();

        //Counts According Status
        $counts['open'] = JobPost::where('posted_by',auth()->user()->id)->where('status','open')->count();
        $counts['under_verification'] = JobPost::where('posted_by',auth()->user()->id)->where('status','under verification')->count();
        $counts['verified'] = JobPost::where('posted_by',auth()->user()->id)->where('status','verified')->count();
        $counts['assigned'] = JobPost::where('posted_by',auth()->user()->id)->where('status','assigned')->count();
        $counts['not_started'] = JobPost::where('posted_by',auth()->user()->id)->where('status','not started')->count();
        $counts['in_progress'] = JobPost::where('posted_by',auth()->user()->id)->where('status','in progress')->count();
        $counts['on_hold'] = JobPost::where('posted_by',auth()->user()->id)->where('status','on hold')->count();
        $counts['completed'] = JobPost::where('posted_by',auth()->user()->id)->where('status','completed')->count();

        return view('frontend.my-accounts.jobs.index',['user'=>auth()->user(),'profile'=>auth()->user()->userprofile() ? auth()->user()->userprofile()->first() : null,'jobs'=>$jobs,'counts'=>$counts]);
    }

    public function show(Request $request , JobPost $job)
    {
        return view('frontend.my-accounts.jobs.show',['job'=>$job]);
    }


}
