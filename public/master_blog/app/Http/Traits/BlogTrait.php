<?php

namespace App\Http\Traits;
use App\Blog;

trait BlogTrait {
    public function index() {
        // Fetch all the blogs from the 'blogs' table.
        $blogsAll = Blog::all();
        return view('author.blogs.index-ajax')->with(compact('blogsAll'));
    }


    public function getData($model)
    {
        // Fetch all the data according to model
        return $model::all();
    }
}