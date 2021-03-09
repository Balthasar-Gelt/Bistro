<?php

namespace App\Cart;

use App\Models\Dish;

class CartItem{

    public $dish, $quantity;

    public function __construct(Dish $dish){

        $this->dish = $dish;
        $this->quantity = 1;
    }
}