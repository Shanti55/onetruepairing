<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ServicesController extends Controller
{
    public function index(Request $request)
    {
        if(!canAccessModule('services'))
            return abort(404);

        if($request->ajax()){
            $services = Service::query();
            $services = $services->with('category')->get();
            return DataTables::of($services)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin-panel.services._actions', ['service' => $row])->render();
                })
                ->rawColumns(['action'])

                ->make(true);
        }
        $categories = Category::all();
        return view('admin-panel.services.index',compact('categories'));
    }

    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('images')) {
            $imageUrls = [];
            foreach ($request->images as $image){
                $path = $image->store('settings', env('FILESYSTEM_DISK'));
                $url = Storage::disk(env('FILESYSTEM_DISK'))->url($path);
                $imageUrls[] = $url;
            }
            $data['images'] = json_encode($imageUrls);
        }

        if($request->id) {
            Service::find($request->id)->update($data);
        } else {
            Service::create($data);
        }

        return response()->json(['message' => 'Service Created Successfully!']);

    }

    public function edit(Request $request, Service $service)
    {
        return response()->json($service);
    }

    public function destroy(Request $request, Service $service)
    {
        $service->delete();

        return response()->json(['message' => 'Service Deleted Successfully!']);
    }
}
