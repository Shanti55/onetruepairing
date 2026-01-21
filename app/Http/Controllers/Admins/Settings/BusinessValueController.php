<?php

namespace App\Http\Controllers\Admins\Settings;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\BusinessValue;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Yajra\DataTables\Facades\DataTables;

class BusinessValueController extends Controller
{

    public function index(Request $request)
    {
        if($request->ajax()){
            $businessValues = BusinessValue::all();

            return DataTables::of($businessValues)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin-panel.settings.business-value._actions', ['businessValue' => $row])->render();
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin-panel.settings.business-value.index');
    }

    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $data = $request->all();

        if($request->id) {
            BusinessValue::find($request->id)->update($data);
        } else {
            BusinessValue::create($data);
        }

        return response()->json(['message' => 'Business Value Created Successfully!']);

    }

    public function edit(Request $request, BusinessValue $value)
    {
        return response()->json($value);
    }

    public function destroy(Request $request, BusinessValue $value)
    {
        $value->delete();

        return response()->json(['message' => 'Business Value Deleted Successfully!']);
    }
}
