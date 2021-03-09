<?php

namespace App\Cart;

use App\Models\Dish;
use App\Cart\CartItem;

class Cart{

    private $items, $total;

    public function __construct()
    {
        $this->items = [];
        $this->total = 0;
    }

    public function initializeWithItem(CartItem $item){

        $this->items[$item->dish->id] = $item;
        $this->total = $item->dish->price;

        return $this;
    }

    public function initializeWithOldCart($oldCart){

        $this->items = $oldCart['items'];
        $this->total = $oldCart['total'];

        return $this;
    }

    public function addItem(CartItem $item){

        if (array_key_exists($item->dish->id, $this->items))
            $this->items[$item->dish->id]->quantity++;
        else
            $this->items[$item->dish->id] = $item;

        $this->addToTotal($item->dish->price);
    }

    public function removeItem(Dish $item){

        if (array_key_exists($item->id, $this->items)){
            
            if(--$this->items[$item->id]->quantity <= 0)
                unset($this->items[$item->id]);
            
            $this->subtractFromTotal($item->price);

            return true;
        }

        return false;
    }

    private function addToTotal($price){

        $this->total += $price;
    }

    private function subtractFromTotal($price){

        $this->total -= $price;
    }

    public function getCartTotal(){

        return $this->total;
    }

    public function getCartItems(){

        return $this->items;
    }

    public function getCartArray(){

        return ["items" => $this->items,"total" => $this->total];
    }

}