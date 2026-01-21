<?php
namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;


class BlogController extends Controller {

    public function index(Request $request){
        if(!canAccessModule('blogs'))
            return abort(404);

        if($request->ajax()){
            $blogs = Blog::with('postedBy')->get();
            return DataTables::of($blogs)
                ->addIndexColumn()
                ->addColumn('name', function ($row){
                    return view('admin-panel.blogs._title', ['blog' => $row])->render();
                })
                ->addColumn('content',function ($row){
                    return  \Illuminate\Support\Str::words(strip_tags($row->content), 30, '...');
                })
                ->addColumn('action', function ($row) {
                    return view('admin-panel.blogs._actions', ['blog' => $row])->render();
                })
                ->addColumn('status', function ($row) {
                    return view('admin-panel.blogs._status', ['blog' => $row])->render();
                })
                ->rawColumns(['name','action','status'])
                ->make(true);
        }
        return view('admin-panel.blogs.index');
    }

    public function create()
    {

        return view('admin-panel.blogs._form');
    }

    public function edit(Blog $blog) {
        return view('admin-panel.blogs._form', compact('blog')); // Pass existing data for editing
    }

    public function store(Request $request) {
        $this->validateBlog($request);

        $data = $request->all();
        $data['posted_by'] = auth()->user()->id;
//        if ($request->hasFile('media')) {
//            $data['media'] = $request->file('media')->store('uploads', 'public');
//        }
        if ($request->hasFile('media')) {
            $media = $request->file('media');
            $path = $media->store('blogs', env('FILESYSTEM_DISK'));
            $url = Storage::disk(env('FILESYSTEM_DISK'))->url($path);
            $data['media'] = $url;
        }

        Blog::create($data);

        return redirect()->route('blogs.index')->with('success', 'Blog created successfully.');
    }

    public function update(Request $request, Blog $blog) {
        $this->validateBlog($request);

        $data = $request->all();
//        if ($request->hasFile('media')) {
//            $data['media'] = $request->file('media')->store('uploads', 'public');
//        }
        if ($request->hasFile('media')) {
            $media = $request->file('media');
            $path = $media->store('blogs', env('FILESYSTEM_DISK'));
            $url = Storage::disk(env('FILESYSTEM_DISK'))->url($path);
            $data['media'] = $url;
        }

        $blog->update($data);

        return redirect()->route('blogs.index')->with('success', 'Blog updated successfully.');
    }

    private function validateBlog($request) {
        return $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'media' => 'nullable|mimes:jpg,jpeg,png,mp4,mov,avi|max:20480',
        ]);
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();
        return response()->json(['message' => 'Blog Deleted Successfully!']);

    }

    public function status(Blog $blog,Request $request)
    {
        $blog->update(['is_active'=>$request->status]);
        return response()->json(['message' => 'Status Updated Successfully!']);
    }

    public function destroyMedia(Request $request)
    {
        $request->validate([
            'id'=>'required',
        ]);

        $blog = Blog::find($request->id);
        if(isset($blog->media)){
            $blog->media = null;
            $blog->save(); // Save changes to the database
        }
        return response()->json(['message' => 'Deleted Successfully']);
    }

}
