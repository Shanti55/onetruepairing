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

class BusinessListingsController extends Controller
{

    public function createOrUpdate(Request $request)
    {
        return view('frontend.business-listings.createOrUpdate',['provider'=>auth()->user(),'profile'=>auth()->user()->serviceproviderprofile() ? auth()->user()->serviceproviderprofile()->first() : null]);
    }

    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'title' => 'required|min:2'
        ]);



        $data = $request->except('categories');
        $data['posted_by'] = auth()->user()->id;
        $job = null;
        if($request->id) {
            $job = JobPost::find($request->id);
            $job->update($data);
            $job->refresh();
        } else {
            $job = JobPost::create($data);
        }
        $job->categories()->sync($request->categories);

        return response()->json(['message' => 'Job Post Created Successfully!']);

    }


}
