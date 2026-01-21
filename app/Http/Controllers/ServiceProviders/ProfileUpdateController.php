<?php
namespace App\Http\Controllers\ServiceProviders;

use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Models\JobPost;
use App\Models\Media;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProfileUpdateController extends Controller
{
    public function __invoke(Request $request)
    {
        $serviceProvider = null;
        $manager = new ImageManager(new Driver()); // Create an instance of ImageManager
        if ($request->id) {
            $serviceProvider = User::find($request->id);
            if ($serviceProvider) {
                $request->validate([
                    'email' => 'nullable | email | unique:users,email,' . $serviceProvider->id,
                    'primary_mobile_number' => 'nullable|string|unique:users,primary_mobile_number,' . $serviceProvider->id,
                    'password' => 'confirmed',
                ]);
            }
        }else{
            $request->validate([
                'company_name' => 'required|min:2',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'email' => 'nullable | email | unique:users',
                'primary_mobile_number' => 'nullable|string|unique:users,primary_mobile_number',
                'password' => 'sometimes|confirmed',
            ]);
        }


        $data = $request->except(['email', 'password','primary_mobile_number', 'password_confirmation','images','name']);
        $data['categories'] = isset($request->categories) && is_array($request->categories) ? json_encode($request->categories) : null;
        $data['services'] = isset($request->services) && is_array($request->services) ? json_encode($request->services) : null;


        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $extension = strtolower($image->getClientOriginalExtension());
            $compressedImage = getCompressedImage($manager,$image,$extension); // 75% quality
            $filename = 'images/' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            Storage::disk(env('FILESYSTEM_DISK'))->put($filename, (string) $compressedImage, 'public');
            $url = Storage::disk(env('FILESYSTEM_DISK'))->url($filename);
            $data['avatar'] = $url;
        }



        if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');
            //  Get file extension and choose correct encoder
            $extension = strtolower($image->getClientOriginalExtension());
            //  Read the image and compress without resizing
            $compressedImage = getCompressedImage($manager,$image,$extension); // 75% quality
            // Generate a unique filename
            $filename = 'images/' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            // Store the compressed image in the selected disk
            Storage::disk(env('FILESYSTEM_DISK'))->put($filename, (string) $compressedImage, 'public');
            // Get the public URL
            $url = Storage::disk(env('FILESYSTEM_DISK'))->url($filename);
            $data['cover_image'] = $url;
        }


        if ($serviceProvider) {
            if ($serviceProvider) {
                $updateData = ['primary_mobile_number' => isset($request->primary_mobile_number) ? $request->primary_mobile_number : $serviceProvider->primary_mobile_number,'email' => isset($request->email) ? $request->email : $serviceProvider->email,'name' => isset($request->name) ? $request->name : $serviceProvider->name];
                if (isset($request->password) && !empty($request->password)) {
                    $updateData['password'] = Hash::make($request->password);
                }
                $serviceProvider->update($updateData);
            }
            if ($serviceProvider->serviceproviderprofile()->exists()) {
                $serviceProvider->serviceproviderprofile->update($data);
            } else {
                $serviceProvider->serviceproviderprofile()->create($data);
            }
        }


        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                //  Get file extension and choose correct encoder
                $extension = strtolower($image->getClientOriginalExtension());
                //  Read the image and compress without resizing
                $compressedImage = getCompressedImage($manager,$image,$extension); // 75% quality
                // Generate a unique filename
                $filename = 'settings/' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                // Store the compressed image in the selected disk
                Storage::disk(env('FILESYSTEM_DISK'))->put($filename, (string) $compressedImage, 'public');
                // Get the public URL
                $url = Storage::disk(env('FILESYSTEM_DISK'))->url($filename);
                // Save to the database
                Media::create([
                    'user_id' => $serviceProvider->id,
                    'url' => $url,
                    'title' => 'gallery'
                ]);
            }
        }

        return response()->json(['message' => 'Profile Updated Successfully!']);
    }

}
