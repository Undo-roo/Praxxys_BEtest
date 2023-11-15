<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItems;
use App\Models\Product;
use Illuminate\Support\Facades\Redis;
use Inertia\Inertia;

class CartController extends Controller
{
    /** 
     * User Cart List
    */
    public function index(){

        $cart = request()->user()->activeCart(['items.product:id,category_id,name,price', 'items.product.category:id,title']);

        // dd($cart);

        return Inertia::render('Customer/Cart/Index', compact('cart'));
    }

    public function add(Request $request, Product $product){
        $data = $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = $request->user()->activeCart();


        // -------- Incase na mas efficient to --------
        // $total = $product->price * $data['quantity'];
        // $quantity = $data['quantity'];

        // $item = CartItems::where('product_id', $product->id)->where('cart_id', $cart->id)->first();

        // if($item){
        //     $total = $total - $item->total; // Current - Previous
        //     $quantity = $quantity - $item->quantity; // Current - Previous
        // }
        // else {
        //     $item = new CartItems;

        //     $item->cart_id = $cart->id;
        //     $item->product_id = $product->id;
        // }

        // $item->quantity = $quantity;
        // $item->total = $total;
        // $item->save();


        // $cart->quantity += $quantity;
        // $cart->total += $total; 
        // $cart->save();
        // -------- Incase na mas efficient to --------

        CartItems::updateOrCreate(
            ['product_id' => $product->id, 'cart_id' => $cart->id ],
            ['quantity' => $data['quantity'], 'total' => $product->price * $data['quantity'] ]
        );
        
        return redirect(route('cart.index'));
    }

    public function edit(Request $request, CartItems $item){

        if( $this->notOwnedByAuthUser( $item->cart ) ){ 
            abort(403);
        }
        
        $price = $item->product->price;
        $total = $request->quantity * $price; 

        $item->quantity = $request->quantity;
        $item->total = $total;
        $item->save();

        return redirect(route('cart.index'));
    }

    public function destroy(CartItems $item){

        $cart = $item->cart;

        if( $this->notOwnedByAuthUser($cart) ){ 
            abort(403);
        }

        $item->delete();

        return redirect(route('cart.index'));
    }


    public function notOwnedByAuthUser($cart){
        return auth()->user()->id != $cart->user_id;
    }

}
