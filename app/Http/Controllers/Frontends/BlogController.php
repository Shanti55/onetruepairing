<?php

namespace App\Http\Controllers\Frontends;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        return view('frontend.blogs.index');
    }
    public function getData(Request $request)
    {
        $query = $request->get('search');

        $blogs = \App\Models\Blog::with('postedBy')
            ->where('is_active', 1)
            ->when($query, function ($q) use ($query) {
                $q->where('title', 'like', "%$query%")
                    ->orWhere('content', 'like', "%$query%");
            })
            ->latest()
            ->get();

        return response()->json($blogs);
    }

}
