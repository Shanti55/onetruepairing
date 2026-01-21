<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use App\Models\Media;
use App\Models\Payment;
use App\Models\ServiceProviderProfile;
use App\Notifications\JobStatus;
use Illuminate\Http\Request;

class DeleteAvatarController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'id'=>'required',
        ]);

        $profile = ServiceProviderProfile::find($request->id);
        if(isset($profile->avatar)){
            $profile->avatar=null;
            $profile->save();
        }
        return response()->json(['message' => 'Deleted Successfully']);
    }

}
