<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Blog;
use App\Tag;
use App\User;
use DataTables;
use Auth;
use Str;

class BlogController extends Controller
{
    
    /* blog Page Show */
    public function index(Request $request)
    {
        $blogs = Blog::where('status', 1)->get();
        $data = [
            'blogs' => $blogs,
        ];
        return view('front.home')->with($data);
    }
    
    public function show(Blog $blog, $slug)
    {
        return 'Blog Single Page';
        $allBlogs = Blog::where('status', 1)->get();
        $blog = Blog::where('slug', $slug)->first();
        return view('front.blog.single', compact('allBlogs', 'blog'));
    }

    // Blog name details check
    public function blogCheck(Request $request)
    { 
        if ($request->ajax())
        {       
            if($request->title_id)
            {
                $blog = Blog::where('title', $request->title)->where('id', $request->title_id)->first();
                if($blog)
                {
                   return response()
                    ->json(['status' => '200', 'message' => 'Blog name accepted!', 'data' => [] ])
                    ->withCallback($request->input('callback'));
                }
            }
            $blog = Blog::where('title', $request->title)->first();     
            if(!$blog)
            {
                return response()
                ->json(['status' => '200', 'message' => 'Blog name accepted!', 'data' => [] ])
                ->withCallback($request->input('callback'));
            }
            return response()
            ->json(['status' => '404', 'message' => $request->title .' has already been taken.'])
            ->withCallback($request->input('callback'));
        }
    }

    /* blog Page Show */
    public function blogPageShow(Request $request)
    {
        $allBlogs = Blog::where('status', 1)->get();
        $blog = Blog::where('slug', $request->slug)->first();
        if(!$blog)
        {
            return redirect()->route('/');
        }
        $data = [
            'blog' => $blog,
            'allBlogs' => $allBlogs
            
        ];
        return view('front.blog.single')->with($data);
    }

    
}
