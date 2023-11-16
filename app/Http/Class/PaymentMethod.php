<?php

namespace App\Http\Class;

class PaymentMethod{

    public static function payment($cart){

        if(count(request()->all()) > 0){

            return ProofPayment::handle();
        }

        $data = PaymentMethod::extract($cart);

        return PaypalPayment::handle($data);
    }

    public static function extract($cart){
        $items = $cart->items();

        $data = $items->select('product_id', 'total', 'quantity')->with('product:id,name')->get();

        $total = $data->sum('total');
        $quantity = $data->sum('quantity');

        $data = $data->toArray();
        
        $data['total'] = $total;
        $data['quantity'] = $quantity;

        return $data;
    }

}