<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Inertia\Inertia;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{

    public $limit = 10;

    protected $prefix = 'Admin/Product/';

    public function index(){

        $categories = Category::select('id', 'title')->get()->toArray();

        return Inertia::render( $this->prefix . 'Index', [
            'categories' => $categories,
        ]);
    }

    public function create(){
        $categories = Category::select('id', 'title')->get()->toArray();
        return Inertia::render( $this->prefix . 'Create', [
            'categories' => $categories,
        ]);
    }

    public function edit($id){
        $categories = Category::select('id', 'title')->get()->toArray();
        $product = Product::find($id);
        
        return Inertia::render( $this->prefix . 'Edit', [
            'categories' => $categories,
            'product' => $product,
        ]);
    }

    public function data(Request $request){
        $products = Product::where(function ($query) use ($request){
            $query->where('description', 'LIKE', '%'. $request->keyword .'%')
            ->orWhere('name', 'LIKE', '%'. $request->keyword .'%');
        });

        if($request->filterBy){
            $products = $products->where('category_id', $request->filterBy);
        }

        $products = $products->with('category')->orderBy('created_at', 'DESC')->paginate(20);
        
        return response()->json($products);
    }

    public function remove(Request $request){
        Product::find($request->id)->delete();

        return response(200);
    }

    public function verifyDetails(Request $request){
        $request->validate([
            'name' => 'required|string',
            'category' => 'required',
            'description' => 'required|string', //|max:2000
            'price' => 'required|numeric|min:1', //|max:2000
        ]);

        return back();
    }

    public function verifyImages(Request $request){
        $request->validate([
            'images.*' => 'required|mimes:png,jpeg,jpg',
        ]);

        return back();
    }


    public function store(Request $request){
        $request->validate([
            'dateTime' => 'required|date',
        ]);

        $data = $request->all();
        // $images = $data['images'];

        unset($data['images'], $data['id'], $data['location']);

        Product::create($data);
        
        return redirect()->route('admin.product.index');
    }

    public function update(Request $request){
        $request->validate([
            'dateTime' => 'required|date',
            'images.*' => 'required|mimes:png,jpeg,jpg',
            'name' => 'required|string',
            'category_id' => 'required',
            'description' => 'required|string',
            'price' => 'required|numeric|min:1', //|max:2000
        ]);

        $product = Product::find($request->id);

        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->description = $request->description;
        $product->dateTime = $request->dateTime;

        $product->save();
        
        return redirect()->route('admin.product.index');
    }
}