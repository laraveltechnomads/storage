<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Blog;
use App\Tag;
use App\User;
use DataTables;
use Auth;
use Str;
use App\Http\Traits\BlogTrait;

class AdminBlogController extends Controller
{
    //Admin blog index
    public function index(Request $request)
    {
        $author = Auth::user();
        $blogs = Blog::latest()->get();

        if ($request->ajax()) {
            $data = Blog::latest()->select('*');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row) use ($author){
                        $btn = '';

                        if($author->id == $row->user_id)
                        {
                           $btn .= '<a href="'. route("admin.blogs.edit", [$row->id]).'" tooltip="Edit"><i class="fa fa-edit"></i></a>
                            <a href="#" class="list-delete" onclick="deleteShowFun('.$row->id.')" tooltip="Delete"><i class="ik ik-trash-2"></i></a>';
                        }
                        $btn .= '<a href="'.route('admin.blog.page.show',$row->id).'" class="mail-msg" tooltip="Show"><i class="fa fa-eye"></i></a>';
                        
                        $div = '<div class="table-actions  float-left"> 
                                '.$btn.'
                            </div>';    
                        return $div;

                    })
                    ->editColumn('author', function($row){
                        return User::where('id', $row->user_id)->first()->name;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.blogs.index', compact('author', 'blogs'));
    }

    //blog single page show
    public function showPage(Blog $blog)
    {
        $tags = Tag::get();
        return $view = view('admin.blogs.showPage', compact('blog', 'tags'));
    }  

    public function create()
    {
        $author = Auth::user();
        $tags = Tag::latest()->get();
        // return view('admin.blogs.jqueryCreate', compact('author', 'tags'));
        return view('admin.blogs.create', compact('author', 'tags'));
    }
    
    public function store(Request $request)
    {
        // return $request;
        DB::beginTransaction();
        try
        {
            if(isset($blog))
            {
                $name = $blog->feature_image;
                $blog_id = $blog->id;
            }else{
                $name = null;
                $blog_id = null;
            }
            if ($request->hasFile('image')) {
                $name = uploadFile($request->file('image'), 'blogs');
            }

            $blog = Blog::create([
                'user_id' => Auth::user()->id,
                'author' => Auth::user()->name,
                'title' => request('title'),
                'meta_title' => request('meta_title'),
                'meta_description' => request('meta_description'),
                'description' => request('description'),
                'feature_image' => $name,
                'tag_id' => request('tags'),
                'status' => 1,
                'slug' => Str::random(10).strtotime("now"),
                'publish_date' => request('publish_date'),
                'category' => request('category'),
                'meta_keywords' => request('meta_keywords')
            ]);

            DB::commit();
            if ($blog) {
                return redirect()->route('admin.blogs.edit', $blog->id)->with('success', 'Blog details created!');
            } else {
                return redirect()->back()->with('error', 'Failed to blog details update! Try again.');
            }
            return redirect()->route('admin.blogs.index');
        } catch (\Exception $e) {
            DB::rollBack();
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    //blog details show
    public function show(Request $request)
    {
        $blog = Blog::find($request->id);
        $tags = Tag::latest()->get();
        return $view = view('admin.blogs.show', compact('blog', 'tags'));
    }
    
    //blog details edit page
    public function edit(BLog $blog)
    {
        $author = Auth::user();
        $tags = Tag::latest()->get();
        return view('admin.blogs.edit', compact('author', 'tags', 'blog'));
    }

    //blog details update
    public function update(Request $request, BLog $blog)
    {
        DB::beginTransaction();
        try
        {
            if(isset($blog))
            {
                $name = $blog->feature_image;
                $blog_id = $blog->id;
                $feature_image = public_path('/images/blogs/').$blog->feature_image;
            }else{
                $name = null;
                $blog_id = null;
                $feature_image = null;
            }
            if ($request->hasFile('image')) {

                $name = uploadFile($request->file('image'), 'blogs');

                if($feature_image && isset($feature_image) && file_exists($feature_image)){
                    unlink($feature_image);
                };
            }

            $blog = Blog::where('id', $blog_id)->update([
                'user_id' => Auth::user()->id,
                'author' => Auth::user()->name,
                'title' => request('title'),
                'meta_title' => request('meta_title'),
                'meta_description' => request('meta_description'),
                'description' => request('description'),
                'feature_image' => $name,
                'tag_id' => request('tags'),
                'status' => 1,
                // 'slug' => $blog->slug ?? Str::random(10).strtotime("now"),
                'publish_date' => request('publish_date') ?? $blog->publish_date,
                'category' => request('category'),
                'meta_keywords' => request('meta_keywords')
            ]);

            DB::commit();
            if ($blog) {
                return redirect()->back()->with('success', 'Blog details updated!');
            } else {
                return redirect()->back()->with('error', 'Failed to blog details update! Try again.');
            }
            return redirect()->route('admin.blogs.index');
        } catch (\Exception $e) {
            DB::rollBack();
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    //Blog Details Destroy
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $blog = Blog::where('id', $request->id)->first();
            if(isset($blog))
            {
                $feature_image = public_path('/images/blogs/').$blog->feature_image;
                if(isset($feature_image) && file_exists($feature_image) ){
                    unlink($feature_image);
                };
                $blog->delete();
                DB::commit();
                return 1;
            }
            return 2; 
        } catch (\Exception $e) {
            DB::rollBack();
            return 2;
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }    
    }
}
