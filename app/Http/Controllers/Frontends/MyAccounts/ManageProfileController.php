<?php

namespace App\Http\Controllers\Frontends\MyAccounts;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\JobPost;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Yajra\DataTables\Facades\DataTables;

class ManageProfileController extends Controller
{

    public function index(Request $request)
    {
        return view('frontend.my-accounts.profiles.index',['user'=>auth()->user(),'profile'=>auth()->user()->userprofile() ? auth()->user()->userprofile()->first() : null]);
    }

    public function storeOrUpdate(Request $request)
    {

        $data = $request->except(['email']);
        $manager = new ImageManager(new Driver()); // Create an instance of ImageManager

        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $extension = strtolower($image->getClientOriginalExtension());
            $compressedImage = getCompressedImage($manager,$image,$extension); // 75% quality
            $filename = 'images/' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            Storage::disk(env('FILESYSTEM_DISK'))->put($filename, (string) $compressedImage, 'public');
            $url = Storage::disk(env('FILESYSTEM_DISK'))->url($filename);
            $data['avatar'] = $url;
        }


        if ($request->id) {
            $serviceProvider = User::find($request->id);
            if ($serviceProvider->userprofile()->exists()) {
                $serviceProvider->userprofile()->update($data);
            } else {
                $serviceProvider->userprofile()->create($data);
            }
        }

        return response()->json(['message' => 'Profile Updated Successfully!']);

    }


}
