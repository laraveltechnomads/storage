<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;
class CategoryController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Categories::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    $url = category_file_show($row->image);
                    return '<img src=' . $url . ' class="avatar" width="50" height="50"/>';
                })
                ->addColumn('status', function ($row) {

                    if ($row->status == 1) {
                        return '<span class="badge badge-success">Active</span>';
                    } else {
                        return '<span class="badge badge-danger">InActive</span>';
                    }

                })
                ->addColumn('action', function ($row) {
                    
                    return '<div>
                        <a href=' . route("admin.category.view", [encrypt($row->id)]) . '>
                        <i class="fas fa-eye" style="color:black;font-size:20px;font-weight:normal;"></i>
                        </a>
                        <a href=' . route("admin.category.edit", [encrypt($row->id)]) . '>
                        <i class="ml-2 fas fa-edit" style="color:black;font-size:20px;font-weight:normal;"></i>
                        </a>
                        <a href="javascript:void(0)" data-id="' . encrypt($row->id) . '" data-href="' . route("admin.category.destroy", [encrypt($row->id)]) . '"  data-target="#confirm-delete" data-toggle="modal">
                        <i class="ml-2 fas fa-trash-alt click_me" style="color:black;font-size:20px;font-weight:normal;"></i>
                        </a>
                    </div>';
                })
                ->rawColumns(['action', 'image', 'status'])
                ->make(true);
        }
        return view('admin.category.index');
    }
    public function create() {
        return view('admin.category.create');
    }
   
    public function store(Request $request) {
        $request->validate([
            'name'     => 'sometimes|required',
            'description' => 'sometimes|required',
            'image'    => 'sometimes|required|mimes:jpeg,jpg,png,svg|max:10000',
        ]);
        $input = $request->all();
        $input['slug'] = preg_replace('/[^A-Za-z0-9_-]+/', '-', $request->name);
        if ($files = $request->file('image')) {
            $name = uploadFile($request->image, 'uploads/categories');
            $input['image'] = $name;
        }
        Categories::create($input);
        return redirect()->route('admin.category.index')->with('success', 'Category add successfully.');
    }

    public function show($id) {
        $data['category'] = Categories::find(decrypt($id));
        return view('admin.category.view', $data);
    }

    public function edit($id) {
        $data['category'] = Categories::find(decrypt($id));
        return view('admin.category.edit', $data);
    }

    public function update(Request $request, $id) {
        $validated = $request->validate([
            'name'     => 'sometimes|required',
            'description' => 'sometimes|required',
            'image'    => 'sometimes|required|mimes:jpeg,jpg,png,svg|max:10000',
        ]);
        $input         = $request->all();
        $input['slug'] = preg_replace('/[^A-Za-z0-9_-]+/', '-', $request->name);
        $category      = Categories::find(decrypt($id));
        if ($files = $request->file('image')) {
            $name = uploadFile($request->image, 'uploads/categories');
            if(!empty($category->image)){
                if (File::exists(category_public_path().$category->image)) 
                {
                    unlink(category_public_path().$category->image);
                }
            }
            $input['image'] = $name;
        }
        $category->update($input);
        return redirect()->route('admin.category.index')->with('success', 'Category update successfully.');
    }

    public function destroy($id) {
        $find_cat = Categories::find(decrypt($id));
        $path     = public_path('uploads/Categories/' . $find_cat->image);
        if(!empty($find_cat->image)){
            if(!empty($find_cat->image)){
                if (File::exists(category_public_path().$find_cat->image)) 
                {
                    unlink(category_public_path().$find_cat->image);
                }
            }
        }
        $find_cat->delete();
        return redirect()->route('admin.category.index')->with('success', 'Category delete successfully.');
    }
}
