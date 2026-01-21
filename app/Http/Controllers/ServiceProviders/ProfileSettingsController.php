<?php

namespace App\Http\Controllers\ServiceProviders;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\JobPost;
use App\Models\ServiceProviderProfile;
use App\Models\User;
use Carbon\Laravel\ServiceProvider;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProfileSettingsController extends Controller
{
    public function index(Request $request)
    {
        return view('service-provider-panel.profile-settings.createOrUpdate',['provider'=>auth()->user(),'profile'=>auth()->user()->serviceproviderprofile() ? auth()->user()->serviceproviderprofile()->first() : null]);
    }

    public function edit(Request $request, JobPost $job)
    {
        $categories = $job->categories()->get()->pluck('id');
        return response()->json(['job'=>$job,'categories'=>$categories]);
    }

    public function destroy(Request $request, JobPost $job)
    {
        $job->delete();

        return response()->json(['message' => 'Posted Job Deleted Successfully!']);
    }


}
