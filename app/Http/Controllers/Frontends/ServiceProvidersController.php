<?php

namespace App\Http\Controllers\Frontends;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\JobPost;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class ServiceProvidersController extends Controller
{

    public function show(User $provider)
    {
        return view('frontend.partials._service-provider-show',['provider'=>$provider,'profile'=>$provider->serviceproviderprofile() ? $provider->serviceproviderprofile()->first() : null]);
    }


}
