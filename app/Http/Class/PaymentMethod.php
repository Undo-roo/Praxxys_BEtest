<?php

namespace App\Http\Class;

class PaymentMethod{

    public static function payment($cart){

        if(count(request()->all()) > 0){

            return ProofPayment::handle();
        }

        return PaypalPayment::handle($cart->total);
    }
}