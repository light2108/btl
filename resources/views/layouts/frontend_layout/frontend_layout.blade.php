<?php
    use App\Models\Banner;
    $banners=Banner::banner();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Stack Developers online Shopping cart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <base href="{{ asset('') }}" />
    <!-- Front style -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link id="callCss" rel="stylesheet" href="frontend/css/front.min.css" media="screen" />
    <link href="frontend/css/base.css" rel="stylesheet" media="screen" />
    <!-- Front style responsive -->
    <link href="frontend/css/front-responsive.min.css" rel="stylesheet" />
    <link href="frontend/css/font-awesome.css" rel="stylesheet" type="text/css">
    <!-- Google-code-prettify -->
    <link href="frontend/js/google-code-prettify/prettify.css" rel="stylesheet" />
    <!-- fav and touch icons -->
    <link rel="shortcut icon" href="frontend/images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
        href="frontend/images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
        href="frontend/images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72"
        href="frontend/images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="frontend/images/ico/apple-touch-icon-57-precomposed.png">
    <style type="text/css" id="enject"></style>
</head>

<body>
    @include('layouts.frontend_layout.frontend_header')
    <!-- Header End====================================================================== -->
    @if (isset($page_name) && $page_name == 'index')
        <div id="carouselBlk">
            <div id="myCarousel" class="carousel slide">
                <div class="carousel-inner">

                    @foreach($banners as $key=>$banner)
                    <div class="item @if($key==0) active @endif">
                        <div class="container">
                            <a href="{{$banner->link}}"><img style="width:100%" src="imgs/{{$banner->image}}"
                                    alt="{{$banner->alt}}" /></a>
                            <div class="carousel-caption">

                                <p>{{$banner->title}}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
            </div>
        </div>
    @endif
    <div id="mainBody">
        <div class="container">
            <div class="row">
                @if(Route::currentRouteName() !='frontend.contact_us')
                @include('layouts.frontend_layout.frontend_sidebar')
                @endif
                @yield('content')
            </div>
        </div>
    </div>
    <!-- Footer ================================================================== -->
    @include('layouts.frontend_layout.frontend_footer')
    <!-- Placed at the end of the document so the pages load faster ============================================= -->
    <script src="frontend/js/jquery.js" type="text/javascript"></script>
    <script src="frontend/js/front.min.js" type="text/javascript"></script>
    <script src="frontend/js/google-code-prettify/prettify.js"></script>

    <script src="frontend/js/front.js"></script>
    <script src="frontend/js/jquery.lightbox-0.5.js"></script>
    <script src="front_js/front_js.js"></script>
</body>

</html>
