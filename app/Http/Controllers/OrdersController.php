<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use App\Http\Requests\StoreOrder;

class OrdersController extends Controller
{
    protected $orderService;

    function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function validateOrder(StoreOrder $request){

        $request->validated();

        return response()->json( ['message' => $this->orderService->insertOrderIntoSession($request)] );
    }

    public function makePayment($type){

        return $this->orderService->handlePayment($type);
    }

    public function success(){

        if(!session()->has('cart') || !session()->has('orderData'))
            return redirect()->route('index');

        return view('pages/order-success', ['orderNumber' => $this->orderService->finishOrder()]);
    }
}
