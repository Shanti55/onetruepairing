<?php

namespace App\Http\Controllers\ServiceProviders;

use App\Http\Controllers\Controller;
use App\Models\JobBid;
use Illuminate\Http\Request;

class JobBidController extends Controller
{
  public function store(Request $request)
{
    $request->validate([
        'job_id'     => 'required',
        'amount'     => 'required|numeric',
        'message'    => 'nullable|string',
        'attachment' => 'nullable|mimes:pdf|max:2048', // Max 2MB PDF
    ]);

    $fileName = null;
    if ($request->hasFile('attachment')) {
        // File ko 'public/uploads/bids' folder mein save karega
        $fileName = time() . '_' . $request->file('attachment')->getClientOriginalName();
        $request->file('attachment')->move(public_path('uploads/bids'), $fileName);
    }

    \App\Models\JobBid::create([
        'job_post_id' => $request->job_id,
        'vendor_id'   => auth()->id(),
        'amount'      => $request->amount,
        'message'     => $request->message,
        'attachment'  => $fileName, // Database mein file ka naam save hoga
    ]);

    return response()->json(['status' => 'success', 'message' => 'Bid with PDF submitted!']);
}
}