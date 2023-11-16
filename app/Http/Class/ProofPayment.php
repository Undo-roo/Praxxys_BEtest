<?php

namespace App\Http\Class;

use App\Http\Interface\PaymentInterface;

class ProofPayment implements PaymentInterface{

    public static function handle($data = null){
        $proof = request()->validate([
            'proofOfPayment' => 'required|mimes:png,jpeg,jpg',
        ]);

        //Kunwari Save sa storage

        request()->user()->newCart();

        return redirect()->route('dashboard.profile')->with('message', 'Success Checkout');
    }
}