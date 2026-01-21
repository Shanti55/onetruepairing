<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use App\Models\Payment;
use App\Models\User;
use App\Notifications\JobStatus;
use Illuminate\Http\Request;

class SwitchFromUserToServiceProviderController extends Controller
{
    public function __invoke(User $user)
    {

        $user->update(['role'=>'service-provider']);
        return response()->json(['message' => 'Switched to Service Provider Successfully']);
    }

}
