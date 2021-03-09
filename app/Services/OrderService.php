<?php

namespace App\Services;

use App\Models\Order;
use App\Cart\Cart;
use App\Mail\OrderCreated;
use App\Models\OrderedDish;
use App\Payment\PaymentFactory;
use Illuminate\Support\Facades\Mail;

class OrderService{

    public function insertOrderIntoSession($data){

        if(!session()->has('cart') || empty(session()->get('cart.items')))
            return 'Cart is empty!';

        session()->put('orderData', [
            'email' => $data->email,
            'name' => $data->name,
            'street' => $data->street,
            'postalCode' => $data->postalCode,
            'city' => $data->city,
            'region' => $data->region,
        ]);

        return 'success';
    }

    public function handlePayment($paymentName){

        $amount = $this->getOrderTotal();
        $paymentType = (new PaymentFactory())->initializePayment($paymentName);

        return $paymentType->pay($amount);
    }

    public function finishOrder(){

        $order = $this->saveOrder((object)session()->get('orderData'), $this->getOrderTotal());
        $this->saveOrderedItems($this->getOrderItems(), $order->id);
        
        $this->sendOrderMail($order->id, $order->email, $this->getOrderTotal(), $this->getOrderItems());

        $this->flushSessions();

        return $order->id;
    }

    private function sendOrderMail($orderId, $orderMail, $orderTotal, $orderedItems){

        Mail::to($orderMail)->send(new OrderCreated($orderedItems, $orderId, $orderTotal));
    }

    private function flushSessions(){

        session()->flush('cart');
        session()->flush('orderData');
    }

    private function  saveOrder($orderData, $orderTotal){

        return Order::create([
            'email' => $orderData->email,
            'name' => $orderData->name,
            'street' => $orderData->street,
            'postalCode' => $orderData->postalCode,
            'city' => $orderData->city,
            'region' => $orderData->region,
            'price' => $orderTotal,
        ]);
    }

    private function saveOrderedItems($items, $orderId){

        foreach ($items as $item) {

            OrderedDish::create([
                'dish_id' => $item->dish->id,
                'order_id' => $orderId,
                'quantity' => $item->quantity
            ]);
        }
    }

    private function getOrderTotal(){

        return (new Cart())->initializeWithOldCart(session()->get('cart'))->getCartTotal() + config('delivery.price');
    }

    private function getOrderItems(){

        return (new Cart())->initializeWithOldCart(session()->get('cart'))->getCartItems();
    }
}