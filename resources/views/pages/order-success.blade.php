@extends('master')

@section('content')

<div class="finnished-order-wrapper">
    <img src="{{ asset('images/icons8-ok.svg') }}" alt="tick">
    <h1>Your order number {{$orderNumber}} has been placed</h1>
    <span>We have sent you email with your order informations.</span>
</div>

@endsection