<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;
use App\Http\Class\PaymentMethod;
use App\Http\Requests\CartAddRequest;
use App\Http\Traits\PrefixController;

class CartController extends Controller
{
    use PrefixController;

    protected $prefix = 'Customer/Cart/';
    /** 
     * User Cart List
    */
    public function index(){

        $cart = request()->user()
        ->activeCart(['items.product:id,category_id,name,price', 'items.product.category:id,title'])
        ->append(['quantity', 'total']);

        return $this->render( compact('cart'), 'Index');
    }

    public function add(CartAddRequest $request, Product $product){
        $data = $request->validated();

        $cart = $request->user()->activeCart();

        CartItem::updateOrCreate(
            ['product_id' => $product->id, 'cart_id' => $cart->id ],
            ['quantity' => $data['quantity'], 'total' => $product->price * $data['quantity'] ]
        );
        
        return redirect(route('cart.index'));
    }

    public function edit(Request $request, CartItem $item){

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

    public function destroy(CartItem $item){

        $cart = $item->cart;

        if( $this->notOwnedByAuthUser($cart) ){ 
            abort(403);
        }

        $item->delete();

        return redirect(route('cart.index'));
    }

    public function checkout(){
        $cart = request()->user()->activeCart(['items.product:id,category_id,name,price', 'items.product.category:id,title']);

        return $this->render( compact('cart'), 'Checkout');
    }

    public function payment(){

        $cart = request()->user()->activeCart();

        return PaymentMethod::payment($cart);
    }

    public function success(){
        
        request()->user()->newCart();
        $success = true;

        return $this->render( compact('success'), 'SuccessCancel');
    }

    public function cancel(){
        $success = false;
        
        return $this->render( compact('success'), 'SuccessCancel');
    }

    public function notOwnedByAuthUser($cart){
        return auth()->user()->id != $cart->user_id;
    }

}
