<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\Category;
// use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    public $limit = 10;

    public function index(){

        $categories = Category::select('id', 'title')->get()->toArray();
        return Inertia::render('Product/Index', [
            'categories' => $categories,
        ]);
    }

    public function create(){
        $categories = Category::select('id', 'title')->get()->toArray();
        return Inertia::render('Product/Create', [
            'categories' => $categories,
        ]);
    }

    public function edit($id){
        $categories = Category::select('id', 'title')->get()->toArray();
        $product = Product::find($id);
        
        return Inertia::render('Product/Edit', [
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

        $products = $products->with('category') ->orderBy('created_at', 'DESC')->paginate(20);

        return response()->json($products);
    }

    public function remove(Request $request){
        Product::find($request->id)->delete();

        return response(200);
    }

    public function redirectOnCreateRefresh(){
        return redirect()->route('product.create');
    }

    public function redirectOnRefresh($id){
        return redirect()->route('product.edit', ['id' => $id]);
    }

    public function verifyDetails(Request $request){

        $request->validate([
            'name' => 'required|string',
            'category' => 'required',
            'description' => 'required|string', //|max:2000
        ]);

        return inertia($request->location);
    }

    public function verifyImages(Request $request){
        $request->validate([
            'images.*' => 'required|mimes:png,jpeg,jpg',
        ]);

        return inertia($request->location);
    }

    public function verifyDetailsEdit(Request $request){

        $request->validate([
            'name' => 'required|string',
            'category' => 'required',
            'description' => 'required|string', //|max:2000
        ]);

        return inertia($request->location);
    }

    public function verifyImagesEdit(Request $request){
        $request->validate([
            'images.*' => 'required|mimes:png,jpeg,jpg',
        ]);

        return inertia($request->location);
    }


    public function store(Request $request){
        $request->validate([
            'dateTime' => 'required|date',
        ]);

        Product::create([
            'name' => $request->name,
            'category_id' => $request->category,
            'description' => $request->description,
            'dateTime' => $request->dateTime,
        ]);
        
        return redirect()->route('product.index');
    }

    public function update(Request $request){

        $request->validate([
            'dateTime' => 'required|date',
            'images.*' => 'required|mimes:png,jpeg,jpg',
            'name' => 'required|string',
            'category' => 'required',
            'description' => 'required|string',
        ]);

        $product = Product::find($request->id);

        dd($product);
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->description = $request->description;
        $product->dateTime = $request->dateTime;

        $product->save();
        
        return redirect()->route('product.index');
    }
}
