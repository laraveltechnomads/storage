<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) 
    {  

        $product = Product::select('*')->orderBy('created_at','DESC')->get();
        $data = [
            'product' => $product
        ];
        if ($request->ajax()) {
            $data = Product::select('products.*','categories.name as cat_name')
            ->join('categories','products.cat_id','=','categories.id')
            ->orderBy('products.id','DESC')
            ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('product_image', function ($row) {

                    $url = product_file_show($row->product_image);
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
                        <a href=' . route("admin.products.show", [encrypt($row->id)]) . '>
                        <i class="fas fa-eye" style="color:black;font-size:20px;font-weight:normal;"></i>
                        </a>
                        <a href=' . route("admin.products.edit", [encrypt($row->id)]) . '>
                        <i class="ml-2 fas fa-edit" style="color:black;font-size:20px;font-weight:normal;"></i>
                        </a>
                        <a href="javascript:void(0)" data-id="' . encrypt($row->id) . '" data-href="' . route("admin.products.delete", [encrypt($row->id)]) . '"  data-target="#confirm-delete" data-toggle="modal">
                        <i class="ml-2 fas fa-trash-alt click_me" style="color:black;font-size:20px;font-weight:normal;"></i>
                        </a>
                    </div>';

                })
                ->rawColumns(['action', 'product_image', 'status'])
                ->make(true);
        }
        return view('admin.products.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['categories'] = Categories::where('status',1)->get();
        return view('admin.products.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'cat_id'     => 'required|exists:categories,id',
            'product_name' => 'required|unique:products',
            'product_image'    => 'required|mimes:jpeg,jpg,png,svg|max:10000|dimensions:width=300,height=300',
        ]);
        
        $input = $request->all();
        // $input['slug'] = preg_replace('/[^A-Za-z0-9_-]+/', '-', $request->name);
        if ($files = $request->file('product_image')) {   
            $input['product_image'] = uploadFile($request->product_image, 'uploads/products');
        }
        Product::create($input);
        return redirect()->route('admin.products.index',[encrypt($request->cat_id)])->with('success', 'Successfully created product.');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['product']  = Product::select('products.*','categories.name as cat_name')
            ->join('categories','products.cat_id','=','categories.id')
            ->where('products.id',decrypt($id))
            ->first();
        return view('admin.products.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['categories'] = Categories::where('status',1)->get();
        $data['product'] = Product::find(decrypt($id));
        return view('admin.products.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'cat_id'     => 'required|exists:categories,id',
            'product_name' => 'required',
            'product_image'    => 'nullable|mimes:jpeg,jpg,png,svg|max:10000|dimensions:width=300,height=300',
        ]);

        
        if(Product::whereNotIn('id', [decrypt($id)])->where('product_name', $request->product_name)->first())
        {
            $request->validate([
                'product_name' => 'required|unique:products,product_name',
            ]);
        }
        $input   = $request->all();
        // $input['slug'] = preg_replace('/[^A-Za-z0-9_-]+/', '-', $request->product_name);
        $product = Product::find(decrypt($id));
        if ($files = $request->file('product_image')) {
            $name = uploadFile($request->product_image, 'uploads/products');
            $path = product_public_path().$product->product_image;
            if(!empty($product->product_image)){
                if (File::exists($path)) {
                    unlink($path);
                }
            }
            $input['product_image'] = $name;
        }
        $product->update($input);
        return redirect()->route('admin.products.index')->with('success', 'Product update successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
            $find_cat = Product::find(decrypt($id));
        $path = product_public_path().$find_cat->product_image;
        if(!empty($find_cat->product_image)){
            if (File::exists($path)) {
                unlink($path);
            } 
        }
        $find_cat->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product delete successfully.');
    }
}
