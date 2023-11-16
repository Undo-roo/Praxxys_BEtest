<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductUpdateRequest;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;
use App\Http\Repository\ProductRepository;
use App\Http\Traits\PrefixController;

class ProductController extends Controller
{
    use PrefixController;
    
    protected $prefix = 'Admin/Product/';

    public function index(){

        $categories = $this->selectableCategory();
        
        return $this->render( compact('categories'), 'Index');
    }

    public function create(){
        $categories = $this->selectableCategory();

        return $this->render( compact('categories'), 'Create');
    }

    public function edit($id){
        $categories = $this->selectableCategory();
        $product = Product::find($id);
        
        $data = compact('categories', 'product');

        return $this->render($data, 'Edit');
    }

    public function data(Request $request){

        $products = ProductRepository::paginateAdminData($request->keyword, $request->filterBy);

        return response()->json($products);
    }

    public function remove(Product $product){
        $product->delete();

        return back();
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
        // di ko na inalis since isa lang naman 
        $request->validate([
            'dateTime' => 'required|date',
        ]);

        $data = $request->all();

        unset($data['images'], $data['id'], $data['location']);

        Product::create($data);
        
        return redirect()->route('admin.product.index');
    }

    public function update(ProductUpdateRequest $request){
        $request->validated();

        $product = Product::find($request->id);

        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->description = $request->description;
        $product->dateTime = $request->dateTime;

        $product->save();
        
        return redirect()->route('admin.product.index');
    }

    public function selectableCategory(){
        return Category::select('id', 'title')->get()->toArray();
    }
}