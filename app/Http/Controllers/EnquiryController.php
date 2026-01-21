<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EnquiryController extends Controller
{
    public function index(Request $request)
    {
        if(!canAccessModule('enquiry'))
            return abort(404);

        if ($request->ajax()) {
            $enquiry = Enquiry::all();

            return DataTables::of($enquiry)
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin-panel.enquiry.index');
    }


    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required',
            'mobile_no' => 'required',
            'email' => 'required',
            'message' => 'required'
        ]);

        $data = $request->all();
        Enquiry::create($data);

//        return response()->json(['message' => 'Created Successfully!']);

    }
}
