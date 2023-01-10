<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Blog;
use App\Tag;
use Str;
use Auth;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }
    public function home()
    {
        if (auth()->check() &&  auth()->user()->hasRole('role_author') ) {
                return redirect()->route('author.dashboard');
        }else if (auth()->check() &&  auth()->user()->hasRole('role_admin') ) {
                return redirect()->route('admin.dashboard');
        }
        return redirect('/login');
    }

    public function clearCache()
    {
        \Artisan::call('cache:clear');
        return view('clear-cache');
    }

    public function homePage()
    {
        $blogs = Blog::where('status', 1)->get();
        return view('front.home', compact('blogs'));
    }
}
