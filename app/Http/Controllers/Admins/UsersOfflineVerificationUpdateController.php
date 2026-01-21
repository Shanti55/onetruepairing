<?php
namespace App\Http\Controllers\Admins;

use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Models\JobPost;
use App\Models\User;
use App\Notifications\OfflineVerificationStatus;
use Illuminate\Http\Request;

class UsersOfflineVerificationUpdateController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'id'=>'required',
            'status' => 'required'
        ]);

        $user = User::find($request->id);

        if(isset($user)){
            $user->update(['offline_verification'=>$request->status]);
        }

        //Send Notification
        $user->notify(new OfflineVerificationStatus($user));

        return response()->json(['message' => 'Offline Verification Updated']);
    }

}
