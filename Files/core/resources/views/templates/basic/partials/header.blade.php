@php
    $heading = getContent('heading.content', true);
    $links = getContent('social_icon.element');
    $policyPages = getContent('policy_pages.element');
@endphp


@if($general->offer)
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Notice
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div class="top-notice text-white bg--base">
    <div class="container text-center">
        <h5 class="d-inline-block mb-0 mr-2 text-white">{{ __($general->offer) }}</h5>
        <button title="Close (Esc)" type="button" class="mfp-close"></button>
    </div>
</div>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Notice
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@endif

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Header
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<header class="header-section">
    <div class="header">
        <div class="header-top-area">
            <div class="container">
                <div class="header-top-content-area d-flex flex-wrap align-items-center justify-content-between">
                    <div class="header-top-left d-flex flex-wrap align-items-center">
                        <p class="top-message text-uppercase d-none d-sm-block mb-0">
                            {{ __(@$heading->data_values->heading) }}
                        </p>
                    </div>
                    <div class="header-top-right d-flex flex-wrap align-items-center">
                        <span class="separator"></span>
                        <div class="header-dropdown d-flex flex-wrap align-items-center">
                            <a href="#" class="pl-0"><i class="fa fa-globe"></i></a>
                            <div class="language-select-area">
                                <select class="language-select langSel">
                                    @foreach($language as $item)
                                        <option value="{{$item->code}}" @if(session('lang') == $item->code) selected  @endif>{{ __($item->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <span class="separator"></span>
                        <div class="header-dropdown dropdown-expanded mx-3 px-1">
                            <a href="#">Links</a>
                            <div class="header-menu">
                                <ul>
                                    @foreach($policyPages as $singlePolicy)
                                        <li>
                                            <a href="{{ route('policy.details', ['policy'=>slug($singlePolicy->data_values->title), 'id'=>$singlePolicy->id]) }}">
                                                {{ __($singlePolicy->data_values->title) }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <span class="separator"></span>
                        <div class="header-social">
                            @foreach($links as $socialLink)
                                <a href="{{ $socialLink->data_values->url }}" target="_blank">
                                    @php
                                        echo $socialLink->data_values->social_icon;
                                    @endphp
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-middle-area">
            <div class="container">
                <div class="header-middle-content d-flex flex-wrap align-items-center justify-content-between">
                    <div class="header-middle-left d-flex flex-wrap align-items-center col-lg-2 w-auto pl-0 mr-3">
                        <button class="mobile-menu-toggler" type="button">
                            <i class="las la-bars"></i>
                        </button>
                        <a href="{{ route('home') }}" class="logo">
                            <img src="" alt="Logo">
                        </a>
                    </div>
                    <div class="header-right w-lg-max d-flex flex-wrap align-items-center ml-auto">
                        <div class="header-menu-content ml-auto mr-auto">
                            <nav class="navbar navbar-expand-lg p-0">
                                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                    <ul class="navbar-nav main-menu mr-auto">
                                        <li><a href="{{ route('home') }}">@lang('Home')</a></li>
                                        <li><a href="{{ route('product.details') }}">@lang('Details')</a></li>
                                        <li><a href="{{ route('tracking') }}">@lang('Tracking')</a></li>
                                        <li><a href="{{ route('about') }}">@lang('About')</a></li>
                                        <li><a href="{{ route('blogs') }}">@lang('Blog')</a></li>
                                        <li><a href="{{ route('contact') }}">@lang('Contact')</a></li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                        <div class="header-contact d-none d-lg-flex pl-1 mr-xl-2 pr-4">
                            <i class="las la-phone-volume"></i>
                            <h6>{{ __(@$heading->data_values->contact) }}<a href="tel:{{ @$heading->data_values->contact_number }}">{{ @$heading->data_values->contact_number }}</a></h6>
                        </div>
                        <div class="dropdown cart-dropdown">
                            <a href="#" class="dropdown-toggle dropdown-arrow icon--style">
                                <i class="las la-shopping-bag"></i>
                                <span class="cart-count badge-circle countCart">{{ $cart->count() }}</span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="dropdownmenu-wrapper">
                                    <div class="dropdown-cart-header">
                                        <span class="countItem">{{ $cart->count() }}</span> @lang('Items')
                                        <a href="{{ route('checkout') }}" class="float-right">@lang('View Cart')</a>
                                    </div>

                                    @php
                                        $totalQty = 0;
                                    @endphp

                                    @foreach($cart as $singleCart)
                                        <div class="dropdown-cart-products {{ $singleCart->id }}">
                                            <div class="product">
                                                <div class="product-details">
                                                    <h4 class="product-title">
                                                        <a href="#0">{{ __(@$product->name) }}</a>
                                                    </h4>
                                                    <span class="cart-product-info">
                                                        @php $totalQty += $singleCart->qty @endphp
                                                        <span class="cart-product-qty">{{ $singleCart->qty }}</span>
                                                        x {{ $general->cur_sym }}{{ afterDiscount(@$product->price, @$product->discount) }}
                                                    </span>
                                                </div>
                                                <figure class="product-image-container">
                                                    <a href="#" data-id="{{ $singleCart->id }}" class="btn-remove remove-product" title="Remove Product"><i
                                                            class="las la-times"></i></a>
                                                </figure>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="dropdown-cart-total">
                                        <span>@lang('Total')</span>
                                        <span class="cart-total-price float-right">
                                            {{ $general->cur_sym }}<span class="cartTotalHeader">{{ afterDiscount(@$product->price, @$product->discount) * $totalQty }}</span>
                                        </span>
                                    </div>
                                    <div class="dropdown-cart-action">
                                        <a href="{{ route('checkout') }}" class="btn--base w-100">@lang('Checkout')</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Header
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Mobile-menu
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div class="mobile-menu-overlay"></div>
<div class="mobile-menu-container">
    <div class="mobile-menu-wrapper">
        <span class="mobile-menu-close"><i class="las la-times"></i></span>
        <nav class="mobile-nav">
            <ul class="mobile-menu">
                <li><a href="{{ route('home') }}">@lang('Home')</a></li>
                <li><a href="{{ route('product.details') }}">@lang('Details')</a></li>
                <li><a href="{{ route('tracking') }}">@lang('Tracking')</a></li>
                <li><a href="{{ route('about') }}">@lang('About')</a></li>
                <li><a href="{{ route('blogs') }}">@lang('Blog')</a></li>
                <li><a href="{{ route('contact') }}">@lang('Contact')</a></li>
            </ul>
        </nav>
    </div>
</div>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Mobile-menu
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@if( !request()->routeIs('checkout') )

@push('script')
<script>
"use strict";

(function ($) {

    var countCart = $('.countCart');
    var countItem = $('.countItem');
    var cartTotalHeader = $('.cartTotalHeader');

    $('.remove-product').on('click', function(){
        var id = $(this).data('id');
        $.ajax({
            type: "post",
            url: "{{ route('delete.cart') }}",
            data: {
                'id': id,
                '_token': '{{ csrf_token() }}',
            },
            success: function(response){

                if(response.success){

                    $('.'+id).remove();
                    countCart.text( countCart.text() - 1 );
                    countItem.text( countCart.text() );
                    cartTotalHeader.text( parseFloat(cartTotalHeader.text()) - response.totalAmount );

                }else if(response.error){

                    $.each(response.error, function(key, value) {
                        notify('error', value);
                    });

                }else{
                    notify('error', response.message);
                }

            },
            error:function(error){
            return;
            }
        });
    });

})(jQuery);
</script>
@endpush

@endif




