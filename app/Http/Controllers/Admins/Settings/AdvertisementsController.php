<?php

namespace App\Http\Controllers\Admins\Settings;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Yajra\DataTables\Facades\DataTables;

class AdvertisementsController extends Controller
{

    public function index(Request $request)
    {
        if($request->ajax()){
            $advertisements = Advertisement::all();

            return DataTables::of($advertisements)
                ->addIndexColumn()
                ->addColumn('ads', function ($row) {
                    return view('admin-panel.settings.advertisements.manage-ads._ads', ['advertisement' => $row])->render();
                })
                ->addColumn('status', function ($row) {
                    return view('admin-panel.settings.advertisements.manage-ads._status', ['advertisement' => $row])->render();
                })
                ->addColumn('action', function ($row) {
                    return view('admin-panel.settings.advertisements.manage-ads._actions', ['advertisement' => $row])->render();
                })
                ->rawColumns(['ads','status','action'])

                ->make(true);
        }

        return view('admin-panel.settings.advertisements.manage-ads.index');
    }

    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'ad_url' => 'nullable',
            'ad_url.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        $manager = new ImageManager(new Driver()); // Create an instance of ImageManager

        //If isset icon
        if ($request->hasFile('ad_url')) {
            $ads = $request->file('ad_url');
            $extension = strtolower($ads->getClientOriginalExtension());
            $compressedImage = getCompressedImage($manager,$ads,$extension); // 75% quality
            $filename = 'advertisements/' . time() . '_' . uniqid() . '.' . $ads->getClientOriginalExtension();
            Storage::disk(env('FILESYSTEM_DISK'))->put($filename, (string) $compressedImage, 'public');
            $url = Storage::disk(env('FILESYSTEM_DISK'))->url($filename);
            $data['ad_url'] = $url;
        }


        if($request->id) {
            Advertisement::find($request->id)->update($data);
        } else {
            Advertisement::create($data);
        }

        return response()->json(['message' => 'Advertisement Created Successfully!']);

    }

    public function edit(Request $request, Advertisement $advertisement)
    {
        return response()->json($advertisement);
    }

    public function destroy(Request $request, Advertisement $advertisement)
    {
        $advertisement->delete();

        return response()->json(['message' => 'Advertisement Deleted Successfully!']);
    }
}
