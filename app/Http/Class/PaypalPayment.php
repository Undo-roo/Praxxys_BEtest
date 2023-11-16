<?php 

namespace App\Http\Class;

use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Http\Interface\PaymentInterface;
use App\Models\Cart;
use Illuminate\Support\Facades\Redirect;

class PaypalPayment implements PaymentInterface {
    
    public static function handle($data){

        $payment = new PaypalPayment;

        return $payment->process($data);
    }

    protected function process($data){

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
                        "currency_code" => "PHP",
                        "value" => $data['total'],
                    ]
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return Redirect::to($links['href']);
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
}