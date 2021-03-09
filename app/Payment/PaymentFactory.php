<?php

namespace App\Payment;

use App\Payment\StripePayment;

class PaymentFactory{

    public function initializePayment($type){

        switch ($type) {
            case 'stripePayment':
                return new StripePayment;
                break;
        }
    }
}