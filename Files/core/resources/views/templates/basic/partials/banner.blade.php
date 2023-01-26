@php
    $banner = getContent('banner.content', true);
@endphp

@if(request()->routeIs('home'))
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Banner
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="banner-section bg-overlay-white ptb-30 bg_img" data-background="{{ getImage('assets/images/frontend/banner/' .@$banner->data_values->banner, '1920x1080') }}">
    <div class="container">
        <div class="row justify-content-center mb-30-none">
            <div class="col-xl-6 col-lg-6 mb-30">
                <div class="banner-content">
                    <h3 class="sub-title text--base">{{ __(@$banner->data_values->title) }}</h3>
                    <h1 class="title">{{ __(@$banner->data_values->heading) }}</h1>
                    <p>{{ __(@$banner->data_values->sub_heading) }}</p>
                    <div class="banner-btn">
                        <a href="{{ @$banner->data_values->button_url }}" class="btn--base">{{ __(@$banner->data_values->button_text) }}</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 mb-30">
                <div class="banner-thumb-area">
                    <div class="banner-thumb">
                        <img src="{{ getImage('assets/images/frontend/banner/' .@$banner->data_values->image, '750x435') }}" alt="drone">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Banner
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@else
    <div class="breadcrumb-area">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('HOME')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __($pageTitle) }}</li>
                </ol>
            </nav>
        </div>
    </div>
@endif

