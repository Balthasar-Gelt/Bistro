<?php

namespace App\Cart;

use App\Cart\Cart;
use App\Cart\CartItem;
use App\Models\Dish;

class CartManager{

    protected $cart;

    function __construct(){
        
        $this->cart = new Cart();

        return $this;
    }

    public function addToCart(Dish $dish){

        $newItem = new CartItem($dish);

        if (!session()->exists('cart')) {

            $this->cart->initializeWithItem($newItem);
            session()->put(['cart'=> $this->cart->getCartArray()]);
        }
        else{

            $this->cart->initializeWithOldCart(session()->get('cart'));
            $this->cart->addItem($newItem);

            session()->put(['cart'=> $this->cart->getCartArray()]);
        }
    }

    public function deleteFromCart(Dish $dish){

        if(!session()->has('cart') || empty(session()->get('cart'))) return 'empty cart';

        $this->cart->initializeWithOldCart(session()->get('cart'));

        if(!$this->cart->removeItem($dish))
            return response()->json( ['message' => 'item does not exist in the cart'] );

        session()->put(['cart'=> $this->cart->getCartArray()]);

        return $dish;
    }
}