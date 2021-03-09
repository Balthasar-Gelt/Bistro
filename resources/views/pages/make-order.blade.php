@extends('master')

@section('stripe-scripts')
<script src="https://js.stripe.com/v3/"></script>
@endsection

@section('content')

<main>
    <div id="app">
        <order-manager 
        currency="{{ config('currency.symbol') }}" 
        categories= "{{$categories}}"
        shipping="{{ config('delivery.price') }}"
        link="{{url('/')}}"
        >
        </order-manager>
    </div>
</main>

@endsection