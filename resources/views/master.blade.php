<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Shojumaru&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Trispace:wght@200;300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('vanillaSelectBox/vanillaSelectBox.css')}}">
    <link rel="stylesheet" href="{{asset('main.css')}}">

    @yield('stripe-scripts')

    <title>Bistro</title>
</head>
<body>

    <div class="nav-wrapper">

        <nav>
            <img class="logo" src="{{asset('images/bistro-logo.png')}}" alt="logo">
            <ul class="nav-group">
                <li><a href="{{ url('/') }}">HOME</a></li>
                <li><a href="{{ url('make-order') }}">MAKE ORDER</a></li>
                <li><a href="" class="scroll-link" scroll-to="about-us">ABOUT US</a></li>
                <li><a href="" class="scroll-link" scroll-to="contact">CONTACT</a></li>
            </ul>
            <div id="burger">
                <span class="french-frie"></span>
                <span class="french-frie"></span>
                <span class="french-frie"></span>
            </div>
        </nav>
        <div class="nav-overlay">
            <ul>
                <li><a href="{{ url('/') }}">HOME</a></li>
                <li><a href="{{ url('make-order') }}">MAKE ORDER</a></li>
                <li><a href="" class="scroll-link" scroll-to="about-us">ABOUT US</a></li>
                <li><a href="" class="scroll-link" scroll-to="contact">CONTACT</a></li>
            </ul>
        </div>
    </div>



    

    <body>
        @yield('content')
    </body>

    

<footer>

    <ul class="footer-content">
        <li id="about-us" class="footer-about">
            <h1>About Us</h1>
            <p>Ever wanted to taste some of the famed dishes from MR. WANG? Or even all of them, but you have the misfortune of not living near our restaurant? Despair no more, because we are bringing our meals online! Simply order from our selection and you can enjoy your meal at anytime, anywhere.</p>
            <p>We are located in a town named Trnava, also called small Vietnam for all the Vietnamese restaurants. Needless to say the competition is weak. Because everybody that has ever tasted some of Mr. Wangs dishes has to agree on their superiority over the competition.</p>
        </li>

        <li id="contact" class="footer-contact">
            <h1>Contact</h1>
            <ul>
                <li><strong>Street</strong>Haochi Jie</li>
                <li><strong>City</strong>Trnava</li>
                <li><strong>Post Code</strong>917 02</li>
            </ul>
        </li>
    </ul>

</footer>

<script src="{{asset('vanillaSelectBox/vanillaSelectBox.js')}}"></script>
<script src="{{asset('main.js')}}"></script>
</body>
</html>
