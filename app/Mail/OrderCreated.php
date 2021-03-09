<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $dishes, $orderNumber, $orderTotal;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($dishes, $orderNumber, $orderTotal)
    {
        $this->dishes = $dishes;
        $this->orderNumber = $orderNumber;
        $this->orderTotal = $this->formatPrice($orderTotal);

        foreach ($dishes as $dish) {
            
            $dish->dish->price = $this->formatPrice($dish->dish->price);
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email/order-created');
    }

    private function formatPrice($price){

        return (string)($price / 100) .' '. config('currency.symbol');
    }
}
