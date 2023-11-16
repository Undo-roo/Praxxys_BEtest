<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;
// use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    // Will need to create a ProductRepo

    protected $prefix = 'Customer/Product/';

    public function index(){

        $pagination = Product::paginate(15);
        $pagination->append('path');


        return Inertia::render("{$this->prefix}Index", compact('pagination'));
    }

    public function show(Product $product){
        return Inertia::render("{$this->prefix}Show", compact('product'));
    }
}