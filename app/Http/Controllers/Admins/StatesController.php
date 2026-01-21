<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class StatesController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $states = State::query();
            $states = $states->get();
            return DataTables::of($states)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    return view('admin-panel.settings.states._image', ['state' => $row])->render();
                })
                ->addColumn('action', function ($row) {
                    return view('admin-panel.settings.states._actions', ['state' => $row])->render();
                })
                ->rawColumns(['image','action'])
                ->make(true);
        }
        $states = State::all();
        return view('admin-panel.settings.states.index',compact('states'));
    }

    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'image.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        //If isset icon
        if ($request->hasFile('image')) {
            $image = $request->image;
            $path = $image->store('settings', env('FILESYSTEM_DISK'));
            $url = Storage::disk(env('FILESYSTEM_DISK'))->url($path);
            $data['image'] = $url;
        }

        if($request->id) {
            State::find($request->id)->update($data);
        } else {
            State::create($data);
        }

        return response()->json(['message' => 'State Updated Successfully!']);

    }

    public function edit(Request $request, State $state)
    {
        return response()->json($state);
    }

    public function destroy(Request $request, State $state)
    {
        $state->delete();
        return response()->json(['message' => 'State Deleted Successfully!']);
    }
}
