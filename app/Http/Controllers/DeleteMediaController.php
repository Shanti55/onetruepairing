<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use App\Models\Media;
use App\Models\Payment;
use App\Notifications\JobStatus;
use Illuminate\Http\Request;

class DeleteMediaController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'id'=>'required',
        ]);

        $media = Media::find($request->id);
        if($media){
            $media->delete();
        }
        return response()->json(['message' => 'Deleted Successfully']);
    }

}
