<?php

namespace App\Http\Interface;

interface PaymentInterface{
    

    public static function handle($cart);
}