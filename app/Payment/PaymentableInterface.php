<?php

namespace App\Payment;

interface PaymentableInterface{

    public function pay($amount);
}
