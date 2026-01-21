<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use App\Models\Media;
use App\Models\Payment;
use App\Models\User;
use App\Notifications\JobStatus;
use Illuminate\Http\Request;

class DeleteAccountController extends Controller
{
    public function __invoke(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'Account Deleted Successfully']);
    }

}
