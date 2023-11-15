<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItems;
use App\Models\Product;
use Illuminate\Support\Facades\Redis;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Inertia\Inertia;

// use Omnipay\Omnipay;

class CartController extends Controller
{
    // protected $gateway;

    // public function __construct(){
    //     $this->gateway = Omnipay::create('PayPal_Rest');
    //     $this->gateway->setClientId(env('PAYPAL_CLIENT_ID'));
    //     $this->gateway->setSecret(env('PAYPAL_CLIENT_SECRET'));
    //     $this->gateway->setTestMode(true);
    // }

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

    public function checkout(){
        $cart = request()->user()->activeCart(['items.product:id,category_id,name,price', 'items.product.category:id,title']);
        
        if(count($cart->items) < 1){
            abort(403);
        }

        return Inertia::render('Customer/Cart/Checkout', compact('cart'));
    }

    public function imagePayment(){

    }

    public function paypalPayment(){

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('cart.success'),
                "cancel_url" => route('cart.cancel'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => "1000.00"
                    ]
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {
            // redirect to approve href
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
            return redirect()
                ->route('cart.checkout')
                ->with('error', 'Something went wrong.');
        }

        return redirect()
        ->route('cart.checkout')
        ->with('error', $response['message'] ?? 'Something went wrong.');
    }

    public function success(){
        $cart = request()->user()->activeCart();
        
        
        return Inertia::render('Customer/Cart/Success');
    }

    public function cancel(){
        return Inertia::render('Customer/Cart/Cancel');
    }

    public function notOwnedByAuthUser($cart){
        return auth()->user()->id != $cart->user_id;
    }

}
