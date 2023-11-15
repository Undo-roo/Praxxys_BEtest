<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Inertia\Inertia;

class CartController extends Controller
{
    /** 
     * User Cart List
    */
    public function index(){
        $cart = Cart::where('user_id', auth()->user()->id)->where('checkout', null)->with('product.category:id,title')->get();

        return Inertia::render('Customer/Cart/Index', compact('cart'));
    }

    public function add(Request $request, Product $product){
        $data = $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|integer|min:1',
        ]);

        Cart::updateOrCreate(
            ['product_id' => $product->id, 'user_id' => auth()->user()->id],
            ['quantity' => $data['quantity'], 'total' => $product->price * $data['quantity'] ]
        );

        // Cart::create([
        //     'product_id' => $product->id,
        //     'user_id' => auth()->user()->id,
        //     'quantity' => $data['quantity'],
        //     'total' => $product->price * $data['quantity'] 
        // ]);

        return redirect(route('cart.index'));
    }

    public function destroy(Cart $cart){

        if(auth()->user()->id != $cart->user_id){
            abort(403);
        }

        $cart->delete();
        return redirect(route('cart.index'));
    }
}
