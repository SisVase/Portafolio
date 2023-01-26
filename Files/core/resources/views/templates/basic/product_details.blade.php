@extends($activeTemplate.'layouts.frontend')

@section('content')
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Product
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="product-section ptb-80">
    <div class="container">
        <div class="row justify-content-center mb-30-none">
            <div class="col-xl-9 mb-30">

                <div class="row justify-content-center mb-30-none">
                    <div class="col-xl-5 col-md-6 mb-30">
                        <div class="xzoom-container">
                            @if($product)
                                <img class="xzoom5" id="xzoom-magnific" alt="image" src="{{getImage(imagePath()['product']['path'].'/'.@$images->first()->image, imagePath()['product']['size'])}}" xoriginal="{{getImage(imagePath()['product']['path'].'/'.@$images->first()->image, imagePath()['product']['size'])}}" />
                            @endif
                            <div class="xzoom-thumbs mt-10">
                                <div class="product-single-slider">
                                    <div class="swiper-wrapper">
                                        @if($product) 
                                            @foreach(@$images as $data)
                                                <div class="swiper-slide">
                                                    <a href="{{getImage(imagePath()['product']['path'].'/'.$data->image, imagePath()['product']['size'])}}">
                                                        <img class="xzoom-gallery5" alt="image"
                                                        src="{{getImage(imagePath()['product']['path'].'/'.$data->image, imagePath()['product']['size'])}}">
                                                    </a>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    @if(@$product)
                        <div class="col-xl-7 col-md-6 mb-30">
                            <div class="product-details-content">
                                <h2 class="product-title">{{ __(@$product->name) }}</h2>
                                <div class="ratings-container d-flex flex-wrap align-items-center">
                                    <div class="product-ratings">
                                        <span class="ratings">
                                            @php echo rating(); @endphp
                                        </span>
                                    </div>
                                    <a href="#" class="rating-link text-dark">( {{ $reviewCount }} @lang('Reviews') )</a>
                                </div>
                                <hr class="short-divider">
                                <div class="price-box">
                                    @if( discount(@$product->price, @$product->discount) > 0)
                                        <s class="text--muted">
                                            {{ $general->cur_sym }}{{ showAmount($product->price, 2) }}
                                        </s>
                                    @endif
                                    <span class="product-price">
                                        {{ $general->cur_sym }}{{ afterDiscount(@$product->price, @$product->discount) }}
                                    </span>
                                </div>
                                <div class="product-desc">
                                    <p>
                                        {{ __(@$product->short_description) }}
                                    </p>
                                </div>
                                <form action="{{ route('update.cart') }}" method="post" class="checkoutForm">
                                    @csrf
                                    @if(gettype(@$product->size) == 'array')
                                        <div class="product-filters-container">
                                            <div class="product-single-filter d-flex flex-wrap align-items-center">
                                                <label class="mb-0 side--label">@lang('Sizes') : </label>
                                                <div class="config-size-list">
                                                    @foreach($product->size as $size)
                                                        <div>
                                                            <input type="radio" name="size" id="{{$size}}" value="{{$size}}">
                                                            <label for="{{$size}}">
                                                                {{ __($size) }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if(gettype($product->color) == 'array')
                                        <div class="product-filters-container">
                                            <div class="product-single-filter d-flex flex-wrap align-items-center">
                                                <label class="mb-0 side--label">@lang('Colors') : </label>
                                                <div class="config-color-list">
                                                    @foreach($product->color as $data)
                                                        <div class="checked-item">
                                                            <input type="radio" name="color" id="{{$data->code}}" value="{{$data->code}}">
                                                            <label for="{{$data->code}}" style="background: #{{$data->code}}">
                                                                <i class="las la-check"></i>
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="product-action d-flex flex-wrap align-items-center">
                                        <div class="product-quantity">
                                            <div class="product-plus-minus">
                                                <div class="dec qtybutton">-</div>
                                                <input class="product-plus-minus-box qty" type="text" name="qty" value="1" readonly>
                                                <div class="inc qtybutton">+</div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn--base add-cart icon-shopping-cart" title="Add to Cart">
                                            @lang('Add to Cart')
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="product-single-tab">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="product-tab-desc" data-toggle="tab" href="#product-desc-content" role="tab"
                                aria-controls="product-desc-content" aria-selected="true">@lang('Description')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="product-tab-reviews" data-toggle="tab" href="#product-reviews-content" role="tab"
                                aria-controls="product-reviews-content" aria-selected="false">@lang('Reviews') ({{ $reviewCount }})</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="product-desc-content" role="tabpanel"
                            aria-labelledby="product-tab-desc">
                            <div class="product-desc-content">
                                <p>
                                    <p>@php echo $product->description; @endphp</p>
                                </p>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="product-reviews-content" role="tabpanel" aria-labelledby="product-tab-reviews">
                            <div class="product-reviews-content">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <ul class="comment-list">
                                            @foreach($reviews as $review)
                                                <li class="comment-container d-flex flex-wrap">
                                                    <div class="comment-box">
                                                        <div class="ratings-container">
                                                            <div class="product-ratings">
                                                                @php
                                                                    $countStar = 5 - $review->rating;
                                                                    $star = null;

                                                                    for($i = 0; $i < $review->rating; $i++){
                                                                        $star .=  '<i class="las la-star"></i>';
                                                                    }

                                                                    for($i = 0; $i < $countStar; $i++){
                                                                        $star .=  '<i class="lar la-star"></i>';
                                                                    }

                                                                    echo $star;
                                                                @endphp
                                                            </div>
                                                        </div>
                                                        <div class="comment-info mb-1">
                                                            <h4 class="avatar-name">{{ __($review->name) }}</h4> -
                                                            <span class="comment-date">{{ showDateTime($review->created_at, 'M d, Y') }}</span>
                                                        </div>
                                                        <div class="comment-text">
                                                            <p>{{ __($review->remark) }}</p>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="mt-4 me-3">
                                        {{ $reviews->links() }}
                                    </div>

                                    <h3 class="reviews-title m-0 mt-4">
                                        <button type="button" class="btn--base reviewBtn">
                                            @lang('Leave A Review')
                                        </button>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Product
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

<div class="modal fade" id="review" tabindex="-1" role="dialog" aria-labelledby="quickView" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content py-4">
            <button type="button" class="close modal-close-btn" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <div class="modal-body">
                <div class="product-single-container">
                    <div class="row mb-30-none">
                        <div class="col-xl-12 col-md-6 mb-30">
                            <form action="{{ route('add.review') }}" method="post">
                                @csrf
                            <div class="product-details-content">
                                <div class="ratings-container d-flex flex-wrap align-items-center">
                                    <div class="product-ratings rating">
                                    <div class="rating-form-group">

                                        @for($i = 0; $i <= 5; $i++)
                                            <label class="star-label">
                                                @for($j = 0; $j < $i; $j++)
                                                    <input type="radio" name="rating" value="{{ $i }}"/>
                                                    <span class="icon"><i class="las la-star"></i></span>
                                                @endfor
                                            </label>
                                        @endfor

                                        </div>
                                    </div>
                                </div>
                                    <div class="product-desc">
                                        <div class="row">
                                            <div class="col-md-12 form-group">
                                                <label for="name" class="text-dark">@lang('Name')</label>
                                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <label for="remark" class="text-dark">@lang('Remark')</label>
                                                <textarea name="remark" id="remark" cols="30" rows="3" required>{{ old('remark') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer p-0 border-0">
                                        <button class="btn btn-lg rounded text-white btn--danger" data-dismiss="modal">@lang('Close')</button>
                                        <button class="btn btn-lg rounded text-white confirmBtn btn--success">@lang('Create')</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('script')
<script>
(function ($) {
    "use strict";
    $('.reviewBtn').on('click', function(){
        $('#review').modal().show();
    });
})(jQuery);
</script>
@endpush


