<?php
namespace App\Http\Controllers\ServiceProviders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



class ProviderSubscriptionsController extends Controller
{
    public function index(Request $request)
    {
        return view('service-provider-panel.subscriptions.index',['provider'=>auth()->user(),'profile'=>auth()->user()->serviceproviderprofile() ? auth()->user()->serviceproviderprofile()->first() : null]);
    }
}
