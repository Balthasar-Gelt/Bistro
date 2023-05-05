<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Cart\CartManager;

class CartController extends Controller
{

    public function addToCart($itemId, CartManager $cartManager){

        if (($dish = Dish::find($itemId)) == null)
            return response()->json( ['message' => 'item does not exist'] );
        
        $cartManager->addToCart($dish);

        return $dish;
    }

    public function deleteFromCart($itemId, CartManager $cartManager){

        if (($dish = Dish::find($itemId)) == null)
            return response()->json( ['message' => 'item does not exist'] );

        return $cartManager->deleteFromCart($dish);
    }

    public function getCart(){

        if(session()->has('cart') && !empty(session()->get('cart')))
            return session()->get('cart');
        else
            return [];
    }

    public function emptyCart(){

        session()->forget('cart');
    }
}
