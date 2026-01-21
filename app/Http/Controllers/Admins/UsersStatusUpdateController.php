<?php
namespace App\Http\Controllers\Admins;

use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Models\JobPost;
use App\Models\User;
use App\Notifications\VendorProfileVerifiedEmail;
use Illuminate\Http\Request;

class UsersStatusUpdateController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'id'=>'required',
            'status' => 'required'
        ]);

        $user = User::find($request->id);

        if(isset($user)){
            $user->update(['status'=>$request->status]);
        }

        if($user->status->value == 'verified'){
            try {
                if ($user->role == 'service-provider'){
                    $user->notify(new VendorProfileVerifiedEmail($user));
                }
            }catch (\Exception $e){

            }
        }

        return response()->json(['message' => 'Status Updated']);
    }

}
