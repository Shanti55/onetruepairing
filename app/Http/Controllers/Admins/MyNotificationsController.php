<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\JobPost;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class MyNotificationsController extends Controller
{

    public function index(Request $request)
    {
        return view('admin-panel.notifications.index',['user'=>auth()->user(),'profile'=>auth()->user()->adminprofile() ? auth()->user()->adminprofile()->first() : null]);
    }


}
