<?php


use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Encoders\WebpEncoder;

function checkFileType($url): mixed
{

    // Get the headers from the URL
    $headers = get_headers($url, 1);


    // Check the content type from headers
    if (isset($headers['Content-Type'])) {
        $contentType = $headers['Content-Type'];

        // Check for JPG image (can be image/jpeg or image/jpg)
        if (strpos($contentType, 'image/jpeg') !== false) {
            return "image";
        }

        // Check for JPG image (can be image/jpeg or image/jpg)
        if (strpos($contentType, 'image/png') !== false) {
            return "image";
        }

        // Check for PDF file
        if (strpos($contentType, 'application/pdf') !== false) {
            return "pdf";
        }
    }
    return null;
}

function getStateImage($state)
{
    if(isset($state))
    {
        $state = \App\Models\State::where('name','LIKE',$state)->first();
        if(isset($state) && isset($state->image)){
            return $state->image;
        }
    }
    return asset('frontend-images/bg-img.jpg');
}

function getJobAcceptedCount($provider)
{
    return \App\Models\JobPost::where('assigned_to',$provider->id)->count();
}

function getJobInProgressCount($provider)
{
    return \App\Models\JobPost::where('assigned_to',$provider->id)->where('status','in progress')->count();
}

function getJobCompletedCount($provider)
{
    return \App\Models\JobPost::where('assigned_to',$provider->id)->where('status','completed')->count();
}

function getJobDeclinedCount($provider)
{
    $jobsDeclined =  \App\Models\JobPost::query();
    $jobsDeclined = $jobsDeclined->whereNotNull('declined_by')->get();
    $count = 0;
    if(count($jobsDeclined)>0){
        foreach ($jobsDeclined as $declined){
            if(in_array($provider->id,json_decode($declined->declined_by))){
                $count+=1;
            }
        }
    }
    return $count;
}


function canAccessModule($module)
{
    if(auth()->user()->role === 'admin' && auth()->user()->is_master) return true;
    if(is_null(auth()->user()->role_permission) ) return true;
    $modules = auth()->user()->role_permission->module_access ?? [];
    return in_array($module, $modules);
}

function hasPermissionFor($permission)
{
    if(auth()->user()->role === 'admin' && auth()->user()->is_master) return true;
    if(is_null(auth()->user()->role_permission)) return true;
    $permissions = auth()->user()->role_permission->permissions ?? [];

    return in_array($permission, $permissions);

}


function generateReferralCode() {
    do {
        $code = strtoupper(\Illuminate\Support\Str::random(6)); // Generates a random 6-character alphanumeric string
    } while (\App\Models\User::where('referral_code', $code)->exists());

    return $code;
}


function getCountByReferral($user)
{
    $count = \App\Models\User::where('referred_by',$user->id)->count();
    return $count;
}


function getCompressedImage($manager,$image,$extension)
{
    $compressedImage = null;
    if ($extension === 'jpg' || $extension === 'jpeg') {
        $compressedImage = $manager->read($image)->encode(new JpegEncoder(quality: 75));
    } elseif ($extension === 'png') {
        $compressedImage = $manager->read($image)->encode(new PngEncoder());
    } elseif ($extension === 'webp') {
        $compressedImage = $manager->read($image)->encode(new WebpEncoder(quality: 75));
    } else {
        // Default to JPEG if format is unknown
        $compressedImage = $manager->read($image)->encode(new JpegEncoder(quality: 75));
    }

    return $compressedImage;
}
