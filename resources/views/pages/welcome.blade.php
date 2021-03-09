@extends('master')

@section('content')

<header>

    <div class="header-overlay"></div>
    <video class="header-img" autoplay muted loop id="myVideo">
        <source src="{{ asset('images/bistro-video.mp4') }}" type="video/mp4">
    </video>

    <h1>MR. WANG'S ONLINE BISTRO</h1>
</header>
    
<main>
    <section class="img-row">
        <div class="row-img">
            <img src="{{ asset('images/mr-wang.png') }}" alt="mr wang">
        </div>
        <div class="row-text">
            <h1>MR. WANG</h1>
            <p>The legend himself. Mr. Wang started his culinary arts journey when he was just five years old. He started cooking his first dishes at his local bistro where he got noticed by the food maestro Chu Xij Tian. Master Tian hired young Wang to one of his restaurants where he trained him for many a year. After obtaining all the knowledge the restaurant and the staff could theach him, he decided to travel around China, and learn new exotic local dishes and tricks to his repertoir. After five long years of travel MR. Wang was called upon by the CCP. The officials found out about his adventures and wanted to congratulate him and gave him a task of utmost importance. After the session was over, he flew to a small eastern province of the EU called Slovakia. Where he spreads the good word about Chinese superiority in all matters culinary. Since the restaurants opening MR. Wang as its headchef has attended many Chinese and international competitions. Among his wast collection of prizes belong eight golden pandas, six diamond rice bowls and four master chef chopping sticks, just to name few.</p>
        </div>
    </section>
</main>

<div class="teaser-wrapper">

    <div class="overlay"></div>

    <div class="teaser">
        <div class="teaser-content">
            <div class="teaser-text">
                <h1>Make an Order</h1>
                <p>Our wide selection of dishes can now be accessed online! Simply click the link, select your favourites, and we will deliver them right to your door!</p>
            </div>
            <a class="full-button" href="{{ url('make-order') }}">Order Now</a>
        </div>
    </div>

</div>

@endsection