<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title> {{ $general->sitename(__($pageTitle)) }}</title>
    @include('partials.seo')

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- fontawesome css link -->
    <link rel="stylesheet" href="{{asset('assets/global/css/all.min.css')}}">
    <!-- bootstrap css link -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/bootstrap.min.css')}}">
    <!-- popup css link -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/magnific-popup.css')}}">
    <!-- x-zoom css link -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/xzoom.css')}}">
    <!-- swipper css link -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/swiper.min.css')}}">
    <!-- lightcase css links -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/lightcase.css')}}">
    <!-- line-awesome-icon css -->
    <link rel="stylesheet" href="{{asset('assets/global/css/line-awesome.min.css')}}">
    <!-- animate.css -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/animate.css')}}">
    <!-- main style css link -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/style.css')}}">
    <!-- main dark style css link -->
    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/dark.css')}}">

    <link rel="stylesheet" href="{{ asset($activeTemplateTrue. 'css/color.php?color='.$general->base_color.'&secondColor='.$general->secondary_color) }}">

    <link rel="stylesheet" href="{{asset($activeTemplateTrue.'css/custom.css')}}">

    @stack('style-lib')

    @stack('style')

</head>
<body>

    @stack('fbComment')

    <div id="version">

        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            Start Preloader
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <div class="preloader">
            <div class="loader-area">
                <div class="loader"></div>
            </div>
        </div>
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            End Preloader
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

        @include($activeTemplate.'partials.header')

        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            Start Scroll-To-Top
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <a href="#" class="scrollToTop"><i class="las la-angle-double-up"></i></a>
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            End Scroll-To-Top
        ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

        <div class="page-wrapper">
            @include($activeTemplate.'partials.banner')
            @yield('content')
        </div>

        @include($activeTemplate.'partials.footer')


        @php
            $cookie = App\Models\Frontend::where('data_keys','cookie.data')->first();
        @endphp

        @if(@$cookie->data_values->status && !session('cookie_accepted'))
            <section class="cookie-policy">
                <div class="container">
                    <div class="cookie-wrapper">
                            <div class="cookie-cont">
                                <span>
                                    @php echo @$cookie->data_values->description @endphp
                                </span>
                                <a href="{{ @$cookie->data_values->link }}" class="text--base" target="_blank">@lang('Read more about cookies')</a>
                            </div>
                        <a href="javascript:void(0)" class="btn--base cookie-close btn-sm cookie-btn">@lang('Accept')</a>
                    </div>
                </div>
            </section>
        @endif

    </div>


<!-- jquery -->
<script src="{{asset('assets/global/js/jquery-3.6.0.min.js')}}"></script>

@stack('script-lib')

<!-- bootstrap js -->
<script src="{{asset($activeTemplateTrue.'js/bootstrap.min.js')}}"></script>
<!-- swipper js -->
<script src="{{asset($activeTemplateTrue.'js/swiper.min.js')}}"></script>
<!-- popup js -->
<script src="{{asset($activeTemplateTrue.'js/jquery.magnific-popup.js')}}"></script>
<!-- x-zoom js -->
<script src="{{asset($activeTemplateTrue.'js/xzoom.js')}}"></script>
<!-- setup js -->
<script src="{{asset($activeTemplateTrue.'js/setup.js')}}"></script>
<!-- lightcase js-->
<script src="{{asset($activeTemplateTrue.'js/lightcase.js')}}"></script>
<!-- wow js file -->
<script src="{{asset($activeTemplateTrue.'js/wow.min.js')}}"></script>

<!-- main -->
<script src="{{asset($activeTemplateTrue.'js/main.js')}}"></script>

@stack('script')

@include('partials.plugins')

@include('partials.notify')

<script>
    $(document).ready(function (){

        "use strict";

        $(".langSel").on("change", function() {
            window.location.href = "{{route('home')}}/change/"+$(this).val() ;
        });

        let logo = `{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}`;

        if({{ $general->dark }}){
            $('#version').addClass('main-dark-version');
            logo = `{{getImage(imagePath()['logoIcon']['path'] .'/darkLogo.png')}}`;
        }else{
            $('#version').removeClass('main-dark-version');
            logo = `{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}`;
        }

        $('.cookie-btn').on('click', function(){
                $.ajax({
                method:'get',
                url:'{{ route("cookie.accept") }}',
                success:function(response){
                    if(response.success){
                        $('.cookie-policy').remove();
                        notify('success', response.message);
                    }
                }
            });
        });

        function setLogo(){
            $('.logo img').attr('src', logo);
        }

        setLogo();

        let navLink = $('.main-menu li a');
        let currentRoute = '{{ url()->current() }}';

        $.each(navLink, function(index, value) {
            if(value.href == currentRoute){
                $(value).addClass('active');
            }
        });

    });
</script>

</body>
</html>
