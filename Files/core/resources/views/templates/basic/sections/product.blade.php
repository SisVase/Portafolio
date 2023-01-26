@php
    $product = App\Models\Product::where('status', 1)->first();
    $review = App\Models\Review::where('status', 1)->count();
    $images = App\Models\ProductImage::latest()->get();
@endphp
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Product
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="product-section pt-80">
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
                                    <span class="rating-link text-dark">( {{ $review }} @lang('Reviews') )</span>
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
                                    @if(gettype($product->size) == 'array')
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
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Product
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->


