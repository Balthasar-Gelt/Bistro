<?php

namespace App\Payment;

use App\Payment\PaymentableInterface;

class StripePayment implements PaymentableInterface{

    public function pay($amount){

        \Stripe\Stripe::setApiKey('sk_test_51HxE57FFdjrD1rG7RQOgveQawy3I5tv3OnjHdo3Y3fBKtBW2A8JrfNwoZ1flg6N6KShjo6i7yWwJ7XAxrAwfyzof00puecbV11');

        $intent = \Stripe\PaymentIntent::create([
            'amount' => $amount,
            'currency' => 'eur',
            'metadata' => ['integration_check' => 'accept_a_payment'],
            ]);

        return json_encode(array('client_secret' => $intent->client_secret));
    }
}
