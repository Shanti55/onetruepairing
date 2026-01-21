<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        if(!canAccessModule('categories'))
            return abort(404);

        if($request->ajax()){
            $categories = Category::with('parentcategory')->whereNull('parent_id')->get();

            return DataTables::of($categories)
                ->addIndexColumn()
                ->addColumn('name', function ($row){
                    return view('admin-panel.categories._name', ['category' => $row])->render();
                })
                ->addColumn('icon', function ($row) {
                    return view('admin-panel.categories._icon', ['category' => $row])->render();
                })
                ->addColumn('image', function ($row) {
                    return view('admin-panel.categories._image', ['category' => $row])->render();
                })
                ->addColumn('action', function ($row) {
                    return view('admin-panel.categories._actions', ['category' => $row])->render();
                })
                ->rawColumns(['name','icon','image','action'])

                ->make(true);
        }

        $categories = Category::all();
        return view('admin-panel.categories.index',compact('categories'));
    }

    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2',
            'icon' => 'nullable',
            'icon.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'image' => 'nullable',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        //If isset icon
        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $path = $icon->store('images', env('FILESYSTEM_DISK'));
            $url = Storage::disk(env('FILESYSTEM_DISK'))->url($path);
            $data['icon'] = $url;
        }

        //If isset image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $icon->store('images', env('FILESYSTEM_DISK'));
            $url = Storage::disk(env('FILESYSTEM_DISK'))->url($path);
            $data['image'] = $url;
        }


        if($request->id) {
            Category::find($request->id)->update($data);
        } else {
            Category::create($data);
        }

        return response()->json(['message' => 'Category Created Successfully!']);

    }

    public function edit(Request $request, Category $category)
    {
        return response()->json($category);
    }

    public function destroy(Request $request, Category $category)
    {
        $category->delete();

        return response()->json(['message' => 'Category Deleted Successfully!']);
    }
}
