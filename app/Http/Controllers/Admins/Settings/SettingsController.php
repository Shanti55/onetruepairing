<?php

namespace App\Http\Controllers\Admins\Settings;

use App\Http\Controllers\Controller;
use App\Models\CmsSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;


class SettingsController extends Controller
{
    public function index(Request $request)
    {
        if(!canAccessModule('settings'))
            return abort(404);

        $setting = CmsSetting::first();
        $providers = User::has('serviceproviderprofile')->with('serviceproviderprofile')->where('role','service-provider')->where('status','verified')->activeSubscription()->get();
        if($request->has('page') && $request->page != null){
            return view('admin-panel.settings.'.$request->page.'.index',compact('setting','providers'));
        }
        return view('admin-panel.settings.index',compact('setting'));
    }

    public function storeOrUpdate(Request $request)
    {
        $data = $request->all();
        $manager = new ImageManager(new Driver()); // Create an instance of ImageManager
        //If isset logo
        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $extension = strtolower($image->getClientOriginalExtension());
            $compressedImage = getCompressedImage($manager,$image,$extension); // 75% quality
            $filename = 'settings/' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            Storage::disk(env('FILESYSTEM_DISK'))->put($filename, (string) $compressedImage, 'public');
            $url = Storage::disk(env('FILESYSTEM_DISK'))->url($filename);
            $data['logo'] = $url;
        }
        //If isset logo
        if ($request->hasFile('footer_logo')) {
            $image = $request->file('footer_logo');
            $extension = strtolower($image->getClientOriginalExtension());
            $compressedImage = getCompressedImage($manager,$image,$extension); // 75% quality
            $filename = 'settings/' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            Storage::disk(env('FILESYSTEM_DISK'))->put($filename, (string) $compressedImage, 'public');
            $url = Storage::disk(env('FILESYSTEM_DISK'))->url($filename);
            $data['footer_logo'] = $url;
        }
        //If isset Qr Code Image
        if ($request->hasFile('qr_code_img')) {
            $image = $request->file('qr_code_img');
            $extension = strtolower($image->getClientOriginalExtension());
            $compressedImage = getCompressedImage($manager,$image,$extension); // 75% quality
            $filename = 'settings/' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            Storage::disk(env('FILESYSTEM_DISK'))->put($filename, (string) $compressedImage, 'public');
            $url = Storage::disk(env('FILESYSTEM_DISK'))->url($filename);
            $data['qr_code_img'] = $url;

        }
        //If isset login banner img
        if ($request->hasFile('login_banner_img')) {
            $image = $request->file('login_banner_img');
            $extension = strtolower($image->getClientOriginalExtension());
            $compressedImage = getCompressedImage($manager,$image,$extension); // 75% quality
            $filename = 'settings/' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            Storage::disk(env('FILESYSTEM_DISK'))->put($filename, (string) $compressedImage, 'public');
            $url = Storage::disk(env('FILESYSTEM_DISK'))->url($filename);
            $data['login_banner_img'] = $url;
        }
        //If isset signup banner img
        if ($request->hasFile('signup_banner_img')) {
            $image = $request->file('signup_banner_img');
            $extension = strtolower($image->getClientOriginalExtension());
            $compressedImage = getCompressedImage($manager,$image,$extension); // 75% quality
            $filename = 'settings/' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            Storage::disk(env('FILESYSTEM_DISK'))->put($filename, (string) $compressedImage, 'public');
            $url = Storage::disk(env('FILESYSTEM_DISK'))->url($filename);
            $data['signup_banner_img'] = $url;
        }
        //If isset header banner img
        if ($request->hasFile('header_banner_img')) {
            $image = $request->file('header_banner_img');
            $extension = strtolower($image->getClientOriginalExtension());
            $compressedImage = getCompressedImage($manager,$image,$extension); // 75% quality
            $filename = 'settings/' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            Storage::disk(env('FILESYSTEM_DISK'))->put($filename, (string) $compressedImage, 'public');
            $url = Storage::disk(env('FILESYSTEM_DISK'))->url($filename);
            $data['header_banner_img'] = $url;
        }

        //If isset Homepage Banner Web
        if ($request->hasFile('homepage_banner_web')) {
            $image = $request->file('homepage_banner_web');
            $extension = strtolower($image->getClientOriginalExtension());
            $compressedImage = getCompressedImage($manager,$image,$extension); // 75% quality
            $filename = 'settings/' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            Storage::disk(env('FILESYSTEM_DISK'))->put($filename, (string) $compressedImage, 'public');
            $url = Storage::disk(env('FILESYSTEM_DISK'))->url($filename);
            $data['homepage_banner_web'] = $url;
        }
        //If isset Homepage Banner Mobile
//        if ($request->hasFile('homepage_banner_mobile')) {
//            $mobileBannerImg = $request->file('homepage_banner_mobile');
//            $path = $mobileBannerImg->store('settings', env('FILESYSTEM_DISK'));
//            $url = Storage::disk(env('FILESYSTEM_DISK'))->url($path);
//            $data['homepage_banner_mobile'] = $url;
//        }

        //If isset search by location img-right side
//        if ($request->hasFile('search_by_location_img')) {
//            $locationImg = $request->search_by_location_img;
//            $locationImgName = time() . '_' . uniqid() . '.' . $locationImg->getClientOriginalExtension();
//            // Move the image to the public/images directory
//            $locationImg->move(public_path('settings'), $locationImgName);
//            // Store the URL
//            $data['search_by_location_img'] = asset('settings/' . $locationImgName);
//        }
        //If isset search by location img-bg
        if ($request->hasFile('search_by_location_bg_img')) {
            $image = $request->file('search_by_location_bg_img');
            $extension = strtolower($image->getClientOriginalExtension());
            $compressedImage = getCompressedImage($manager,$image,$extension); // 75% quality
            $filename = 'settings/' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            Storage::disk(env('FILESYSTEM_DISK'))->put($filename, (string) $compressedImage, 'public');
            $url = Storage::disk(env('FILESYSTEM_DISK'))->url($filename);
            $data['search_by_location_bg_img'] = $url;
        }
        //If isset contact us img
        if ($request->hasFile('contact_us_img')) {
            $image = $request->file('contact_us_img');
            $extension = strtolower($image->getClientOriginalExtension());
            $compressedImage = getCompressedImage($manager,$image,$extension); // 75% quality
            $filename = 'settings/' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            Storage::disk(env('FILESYSTEM_DISK'))->put($filename, (string) $compressedImage, 'public');
            $url = Storage::disk(env('FILESYSTEM_DISK'))->url($filename);
            $data['contact_us_img'] = $url;
        }

        //If isset header banner img
        if ($request->hasFile('add_listing_banner_img')) {
            $image = $request->file('add_listing_banner_img');
            $extension = strtolower($image->getClientOriginalExtension());
            $compressedImage = getCompressedImage($manager,$image,$extension); // 75% quality
            $filename = 'settings/' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            Storage::disk(env('FILESYSTEM_DISK'))->put($filename, (string) $compressedImage, 'public');
            $url = Storage::disk(env('FILESYSTEM_DISK'))->url($filename);
            $data['add_listing_banner_img'] = $url;
        }
        //If isset contact us bg img
        if ($request->hasFile('contact_us_bg_img')) {
            $image = $request->file('contact_us_bg_img');
            $extension = strtolower($image->getClientOriginalExtension());
            $compressedImage = getCompressedImage($manager,$image,$extension); // 75% quality
            $filename = 'settings/' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            Storage::disk(env('FILESYSTEM_DISK'))->put($filename, (string) $compressedImage, 'public');
            $url = Storage::disk(env('FILESYSTEM_DISK'))->url($filename);
            $data['contact_us_bg_img'] = $url;
        }
        //Ads Homepage-1
        if($request->hasFile('ads_on_home_page_one.image')){
            $image = $data['ads_on_home_page_one']['image'];
            $extension = strtolower($image->getClientOriginalExtension());
            $compressedImage = getCompressedImage($manager,$image,$extension); // 75% quality
            $filename = 'settings/' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            Storage::disk(env('FILESYSTEM_DISK'))->put($filename, (string) $compressedImage, 'public');
            $url = Storage::disk(env('FILESYSTEM_DISK'))->url($filename);
            $data['ads_on_home_page_one']['image'] = $url;
        }

        if($request->ads_on_home_page_one){
            $data['ads_on_home_page_one'] = json_encode($data['ads_on_home_page_one']);
        }

        //Ads Homepage-2
        if($request->hasFile('ads_on_home_page_two.image')){
            $image = $data['ads_on_home_page_two']['image'];
            $extension = strtolower($image->getClientOriginalExtension());
            $compressedImage = getCompressedImage($manager,$image,$extension); // 75% quality
            $filename = 'settings/' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            Storage::disk(env('FILESYSTEM_DISK'))->put($filename, (string) $compressedImage, 'public');
            $url = Storage::disk(env('FILESYSTEM_DISK'))->url($filename);
            $data['ads_on_home_page_two']['image'] = $url;
        }

        if($request->ads_on_home_page_two){
            $data['ads_on_home_page_two'] = json_encode($data['ads_on_home_page_two']);
        }

        //Ads Homepage-3
        if($request->hasFile('ads_on_home_page_three.image')){
            $image = $data['ads_on_home_page_three']['image'];
            $extension = strtolower($image->getClientOriginalExtension());
            $compressedImage = getCompressedImage($manager,$image,$extension); // 75% quality
            $filename = 'settings/' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            Storage::disk(env('FILESYSTEM_DISK'))->put($filename, (string) $compressedImage, 'public');
            $url = Storage::disk(env('FILESYSTEM_DISK'))->url($filename);
            $data['ads_on_home_page_three']['image'] = $url;
        }

        if($request->ads_on_home_page_three){
            $data['ads_on_home_page_three'] = json_encode($data['ads_on_home_page_three']);
        }

        //Ads Browsepage
        if($request->hasFile('ads_on_browse_page_one.image')){
            $image = $data['ads_on_browse_page_one']['image'];
            $extension = strtolower($image->getClientOriginalExtension());
            $compressedImage = getCompressedImage($manager,$image,$extension); // 75% quality
            $filename = 'settings/' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            Storage::disk(env('FILESYSTEM_DISK'))->put($filename, (string) $compressedImage, 'public');
            $url = Storage::disk(env('FILESYSTEM_DISK'))->url($filename);
            $data['ads_on_browse_page_one']['image'] = $url;
        }
        if($request->ads_on_browse_page_one){
            $data['ads_on_browse_page_one'] = json_encode($data['ads_on_browse_page_one']);
        }

        if($request->featured_providers){
            $data['featured_providers'] = json_encode($request->featured_providers);
        }

        //About Us Video
        if ($request->hasFile('about_us_video')) {
            $aboutUsVideo = $request->file('about_us_video');
            $path = $aboutUsVideo->store('videos', env('FILESYSTEM_DISK'));
            $url = Storage::disk(env('FILESYSTEM_DISK'))->url($path);
            $data['about_us_video'] = $url;
        }

        if($request->id) {
            CmsSetting::find($request->id)->update($data);
        } else {
            CmsSetting::create($data);
        }

        return response()->json(['message' => 'Settings Successfully!']);

    }

}
