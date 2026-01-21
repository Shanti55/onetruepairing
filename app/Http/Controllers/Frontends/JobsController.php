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

class JobsController extends Controller
{

    public function index(Request $request)
    {
        return view('frontend.jobs.index');
    }


    public function show(Category $category)
    {
        return view('frontend.jobs.show',compact('category'));
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

    public function fetchJobs()
    {
        $filters = null;
        if(request()->has('filters')){
            $filters = request('filters');
        }

       $jobs = JobPost::with(['categories', 'postedBy.serviceproviderprofile'])
    ->whereIn('status', ['open','verified']);

           

        if(request()->has('filters')){
            $jobs = $jobs->where(function ($query) use ($filters){
                    if(isset($filters['search_by_location'])){
                        $query->orWhere(function ($query) use ($filters){
                            $query->orWhere('location','LIKE','%'.$filters['search_by_location'].'%');
                            $query->orWhere('pin_code',$filters['search_by_location']);
                            $query->orWhere('city',$filters['search_by_location']);
                            $query->orWhere('state',$filters['search_by_location']);
                        });
                    }
                    if(isset($filters['search'])){
                        $query->orWhere(function ($query) use ($filters){
                            $query->orWhere('title','LIKE','%'.$filters['search'].'%');
                        });
                    }
                    if(isset($filters['categories'])){
                        $query->whereHas('categories',function ($query) use ($filters){
                            $query->whereIn('category_id',$filters['categories']);
                        });
                    }
            });

        }

        $jobs = $jobs->skip(request('skip'))->limit(8)->get();
        $categories = Category::all()->select(['id','name']);
        return response()->json([
            'jobs'=>$jobs,
            'categories'=>$categories,
        ]);

    }


}
