@component('mail::message')
<h1>Thank you for your order.</h1>

<span>Your order {{$orderNumber}} has been registered and is being prepared by our chefs.</span>

<h2>Your order</h2>

<ul>
    @foreach ($dishes as $dish)
        <li>
            <span>{{$dish->quantity}}x</span>
            {{ $dish->dish->name }}
            <span>{{$dish->dish->price}}</span>
        </li>
    @endforeach
</ul>

<strong class="order-total">Order total: {{$orderTotal}}</strong>
{{ config('app.name') }}
@endcomponent
