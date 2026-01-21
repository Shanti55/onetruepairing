<?php

namespace App\Http\Controllers\Frontends;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\JobPost;
use App\Models\Service;
use App\Models\ServiceProviderProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class BrowseListingsController extends Controller
{

    public function index(Request $request)
    {
       $categories = Category::query();
       $categories = $categories->whereNull('parent_id')->get();
       return view('frontend.browses.index',compact('categories'));
    }

    public function fetchListings()
    {
        $filters = null;
        if(request()->has('filters')){
            $filters = request('filters');
        }

        $serviceProviders = User::has('serviceproviderprofile')->with('serviceproviderprofile')->where('role','service-provider')->where('status','verified')->activeSubscription();
       // $serviceProviders = User::has('serviceproviderprofile')->with('serviceproviderprofile')->where('role','service-provider');

        if(request()->has('filters')){
            $category = null;
            $subCategory = null;
            if(request()->has('filters') && isset($filters['category'])){
                $category = Category::where('name','LIKE','%'.$filters['category'].'%')->first();
            }
            if(request()->has('filters') && isset($filters['subCategory'])){
                $filters['categories'] = $filters['subCategory'];
            }

            $filters['category'] = isset($filters['category']) && isset($category) ? $category->id : null;

            $filters['location'] = isset($filters['location']) ? $filters['location'] : null;

            if(isset($filters['location'])){
                $filters['location'] = explode(", ", $filters['location']);
            }


            $serviceProviders = $serviceProviders->whereHas('serviceproviderprofile',function ($query) use ($filters){
                $query->where(function ($query)use($filters){
                    if(request()->has('filters') && isset($filters['categories'])){
                        foreach (array_values($filters['categories']) as $categoryId) {
                            $query->orWhereJsonContains('categories', $categoryId);
                        }
                    }elseif(request()->has('filters') && request('filters.category') && $filters['category'] == null){
                        $query->where('company_name',request('filters.category'));
                    }else{
                        if(isset($filters['category'])){
                            $query->whereJsonContains('categories',strval($filters['category']));
                        }
                    }

                    if(isset($filters['location'])){
                        $query->orWhere(function ($query) use ($filters){
                            $query->orWhereIN('pin_code',$filters['location']);
                            $query->orWhereIN('city',$filters['location']);
                            $query->orWhereIN('state',$filters['location']);
                        });
                    }
                });
            });


        }

        $serviceProviders = $serviceProviders->skip(request('skip'))->limit(8)->get();
        if (request()->has('filters') && isset($filters['rating'])) {
            $serviceProviders = $serviceProviders->filter(function ($serviceProviders) use ($filters) {
                return $serviceProviders->rating >= $filters['rating'];
            })->values(); // Reset keys after filtering
        }

        if (request()->has('filters') && isset($filters['sort_by'])) {
            switch ($filters['sort_by']) {
                case 'rating_desc':
                    $serviceProviders = $serviceProviders->sortByDesc('rating')->values();
                    break;
                case 'rating_asc':
                    $serviceProviders = $serviceProviders->sortBy('rating')->values();
                    break;
                case 'name_asc':
                    $serviceProviders = $serviceProviders->sortBy(function ($sp) {
                        return strtolower($sp->name);
                    })->values();
                    break;
                case 'name_desc':
                    $serviceProviders = $serviceProviders->sortByDesc(function ($sp) {
                        return strtolower($sp->name);
                    })->values();
                    break;
            }
        }

        $categories = Category::all()->select(['id','name']);
        $subcategories = null;
        if(isset($category)){
            $subcategories = Category::where('parent_id',$category->id)->get();
            if(!count($subcategories)){
                if(isset($category->parent_id)){
                    $subcategories = Category::where('parent_id',$category->parent_id)->get();
                }
            }
        }

        return response()->json([
            'listings'=>$serviceProviders,
            'categories'=>$categories,
            'subcategories'=>$subcategories,
        ]);

    }
    public function fetchListingsAds()
    {
        $advertisements = \App\Models\Advertisement::where('display_on_page', 'Service Listing')
            ->where('is_enabled', 1)
            ->get()
            ->values(); // Reset the index

        // Manually adjust the index starting from 4
        $advertisements = $advertisements->mapWithKeys(function ($item, $index) {
            return [($index*8 + 8) => $item];
        });
        return response()->json([
            'advertisements'=>$advertisements,
        ]);

    }

    function extractLocationDetails($inputString) {
        $inputString = "New York, New York 10001";
        // Define a regex pattern to match city, state, and pincode
        // Assumes city and state can have multiple words and pincode is a 6-digit number
        $pattern = '/([a-zA-Z\s]+),?\s*([a-zA-Z\s]+)\s*(\d{6})/i';

        if (preg_match($pattern, $inputString, $matches)) {
            // Return an associative array with city, state, and pincode
            return [
                'city' => trim($matches[1]),
                'state' => trim($matches[2]),
                'pincode' => trim($matches[3]),
            ];
        }

        return null; // Return null if no match is found
    }

}
