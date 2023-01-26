@extends($activeTemplate.'layouts.frontend')

@section('content')
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Cart
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="blog-section ptb-80">
    <div class="container">
        <div class="row mb-30-none">
            <div class="col-xl-12 mb-30">
                <div class="cart-area">
                    <div class="panel-table table-area">
                        <div class="panel-card-body">
                            <table class="custom-table cart-list-table">
                                <thead>
                                    <tr>
                                        <th class="text-left">@lang('SL')</th>
                                        <th class="text-left">@lang('Product Name')</th>
                                        <th>@lang('Quantity')</th>
                                        <th>@lang('Size')</th>
                                        <th>@lang('Color')</th>
                                        <th>@lang('Price')</th>
                                        <th>@lang('Total')</th>
                                        <th>@lang('Remove')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($carts as $cart)
                                        <tr class="{{ $cart->id }}">
                                            <td data-label="@lang('SL')"></td>
                                            <td data-label="@lang('Product Name')" class="text-left">
                                                <div class="p-item d-flex flex-wrap align-items-center">
                                                    <div class="p-content">
                                                        <h5 class="title"><a href="#0">{{ __($product->name) }}</a></h5>
                                                    </div>
                                                </div>
                                            </td>
                                            <td data-label="@lang('Quantity')">
                                                <div class="product-quantity mr-0">
                                                    <div class="product-plus-minus">
                                                        <div class="dec qtybutton" data-id="{{ $cart->id }}">-</div>
                                                        <input class="product-plus-minus-box qty" type="text" name="qtybutton" value="{{ $cart->qty }}" id="cartId{{$cart->id}}" readonly>
                                                        <div class="inc qtybutton" data-id="{{ $cart->id }}">+</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td data-label="@lang('Size')">
                                                <span>{{ $cart->size ?? __('N/A') }}</span>
                                            </td>
                                            <td data-label="@lang('Color')">
                                                <div class="config-color-list">
                                                    @if($cart->color)
                                                        <label for="3dffde" style="background: #{{ $cart->color }}">
                                                            <i class="las la-check"></i>
                                                        </label>
                                                    @else 
                                                        @lang('N/A')
                                                    @endif
                                                </div>
                                            </td>
                                            <td data-label="@lang('Price')">
                                                {{ $general->cur_sym }}<span>{{ afterDiscount($product->price, $product->discount) }}</span>
                                            </td>
                                            <td data-label="@lang('Total')">
                                                {{ $general->cur_sym }}<span class="tableTotal">{{ afterDiscount($product->price, $product->discount) * $cart->qty }}</span>
                                            </td>
                                            <td data-label="@lang('Remove')">
                                                <a href="javascript:void(0)" class="remove-product" data-id="{{ $cart->id }}"><i class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="cart-bottom mt-30">
                        <div class="cart-checkout-box d-flex flex-wrap justify-content-between align-items-center">
                            <div class="coupon">
                                <input type="text" name="coupon" placeholder="@lang('Coupon Code')" class="form--control couponField">
                                <button class="submit-btn couponBtn">@lang('Apply Coupon')</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="shipping-details-area mt-60">
                    <form class="shipping-form" action="{{ route('proceed.checkout') }}" method="post">
                        @csrf
                        <div class="row justify-content-center mb-30-none">
                            <div class="col-xl-6 col-lg-6 mb-30">
                                <div class="shipping-wrapper">
                                    <h4 class="title mb-20">@lang('Shipping Details')</h4>
                                    <div class="d-flex flex-wrap justify-content-center m--12">

                                        <div class="form-group checkout--rearrange">
                                            <input type="text" name="name" class="form--control" value="{{old('name')}}" placeholder="@lang('Name')" required>
                                        </div>
                                        <div class="form-group checkout--rearrange">
                                            <input type="email" name="email" class="form--control" value="{{old('email')}}" placeholder="@lang('Email')" required>
                                        </div>
                                        <div class="form-group checkout--rearrange">
                                            <input type="text" name="phone" class="form--control" value="{{old('phone')}}" placeholder="@lang('Phone')" required>
                                        </div>

                                        @if($general->shipping != null && gettype($general->shipping) == 'object')
                                            @foreach($general->shipping as $k => $v)
                                                @if($v->type == "text")
                                                    <div class="form-group checkout--rearrange">
                                                        <input type="text" name="{{$k}}" class="form--control" value="{{old($k)}}" placeholder="{{__($v->field_level)}}"
                                                        {{ $v->validation == "required" ? 'required' : null }}>
                                                        @if($errors->has($k))
                                                            <span class="text-danger">{{ __($errors->first($k)) }}</span>
                                                        @endif
                                                    </div>
                                                @elseif($v->type == "textarea")
                                                    <div class="form-group checkout--rearrange w-100 order-1">
                                                        <textarea name="{{$k}}"  class="form--control"  placeholder="{{__($v->field_level)}}" rows="3"
                                                        {{ $v->validation == "required" ? 'required' : null }}
                                                        >{{old($k)}}</textarea>
                                                        @if($errors->has($k))
                                                            <span class="text-danger">{{ __($errors->first($k)) }}</span>
                                                        @endif
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif

                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 mb-30">
                                <div class="cart-total-area">
                                    <h4 class="title mb-20">@lang('Cart Total')</h4>
                                    <div class="panel-table table-area">
                                        <div class="panel-card-body">
                                            <table class="custom-table">
                                                <thead>
                                                    <tr>
                                                        <th>@lang('Cart Total')</th>
                                                        <th>@lang('Discount')</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td data-label="@lang('Cart Total')">
                                                            {{ $general->cur_sym }}
                                                            <span class="cartTotal">{{ $carts->sum('qty') * afterDiscount($product->price, $product->discount) }}</span>
                                                        </td>
                                                        <td data-label="@lang('Discount')">
                                                            <span class="couponAmount">0</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="paymentDetails mt-30">
                                    </div>

                                    <div class="payment-dropdown-area mt-30">
                                        <h4 class="title mb-20">@lang('Payment Method')</h4>
                                        <select class="form--control gateway" name="gatewayId" required>
                                            <option value="">@lang('Please Select One')</option>
                                            @foreach($gatewayCurrency as $data)
                                                <option value="{{ $data->id }}">{{__($data->name)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="checkout-btn d-flex justify-content-end form-group mt-30">
                                        <button type="submit" class="submit-btn w-auto">@lang('Proceed To Checkout')</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Cart
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Modal
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div class="modal fade custom--modal" id="addCartModal" tabindex="-1" role="dialog" aria-labelledby="addCartModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h3>@lang('Are you sure to pament !')</h3>
            </div>
                @if($paymentText)
                    <div class="modal-body add-cart-box text-center">
                        <p>
                            {{ __(@$paymentText->data_values->description) }}
                        </p>
                    </div>
                @endif
            <div class="modal-footer justify-content-center">
                <button class="btn btn--danger rounded text-white" data-dismiss="modal">@lang('Close')</button>
                <button class="btn confirmBtn btn--success rounded text-white">@lang('Confirm')</button>
            </div>
        </div>
    </div>
</div>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Modal
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@endsection

@push('script')
<script>

    "use strict";

    (function ($) {

        sessionStorage.removeItem('coupon');

        var countCart = $('.countCart');
        var cartTotal = $('.cartTotal');
        var countItem = $('.countItem');
        var couponAmount = $('.couponAmount');
        var cartTotalHeader = $('.cartTotalHeader');

        var price = @json(afterDiscount($product->price, $product->discount));
        var oldPrice = @json(@$carts->sum('qty') * afterDiscount(@$product->price, @$product->discount));

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
                        cartTotal.text( parseFloat(cartTotal.text()) - response.totalAmount );
                        cartTotalHeader.text( parseFloat(cartTotalHeader.text()) - response.totalAmount );

                        $('.gateway').val('');
                        $('.paymentDetails').empty();

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

        $(document).on('click', '.qtybutton', function(){

            var id = $(this).data('id');
            var cartInput = $('#cartId'+id).val();

            $.ajax({
                type: "post",
                url: "{{ route('update.qty') }}",
                data: {
                    'id': id,
                    'input': cartInput,
                    '_token': '{{ csrf_token() }}',
                },
                success: function(response){

                    if(response.success){

                        var row = $('table .'+id +' .tableTotal');
                        row.text(response.totalPrice);

                        var afterChangeQty = 0;

                        if(response.type == '+'){
                            afterChangeQty = oldPrice += parseFloat(response.afterChange);
                            oldPrice = afterChangeQty;
                        }else{
                            afterChangeQty = oldPrice -= parseFloat(response.afterChange);
                            oldPrice = afterChangeQty;
                        }

                        cartTotal.text(afterChangeQty);
                        cartTotalHeader.text(afterChangeQty);

                        $('.gateway').val('');
                        $('.paymentDetails').empty();

                    }else if(response.error){

                        $.each(response.error, function(key, value) {
                            notify('error', value);
                        });

                    }else{
                        notify('error', response.message);
                    }

                },
                error: function(error){
                    return;
                }
            });

        });

        $('.couponBtn').on('click', function(){

            var couponFiled = $('.couponField');

            if(!couponFiled.val()){
                notify('error', 'Coupon Field is required');
                return;
            }

            $.ajax({
                type: "post",
                url: "{{ route('coupon') }}",
                data: {
                    'input': couponFiled.val(),
                    '_token': '{{ csrf_token() }}',
                },
                success: function(response){

                    if(response.success){

                        couponAmount.text(response.discount);
                        notify('success', response.message);
                        sessionStorage.setItem('coupon', JSON.stringify(response.row) );

                        $('.gateway').val('');
                        $('.paymentDetails').empty();

                    }else if(response.error){

                        $.each(response.error, function(key, value) {
                            notify('error', value);
                        });

                    }else{
                        notify('error', response.message)
                    }

                },
                error: function(error){
                    return;
                }
            });

        });

        $('.gateway').on('change', function(){

            var currencyId = $(this).val();

            if(!currencyId){
                return notify('error', 'Currency field is required');
            }

            $.ajax({
                type: "post",
                url: "{{ route('currency.info') }}",
                data: {
                    'id': currencyId,
                    '_token': '{{ csrf_token() }}',
                },
                success: function(response){

                    if(response.success){

                        var row = response.row;
                        var baseSymbol = @json($general->cur_sym);
                        var coupon = JSON.parse(sessionStorage.getItem('coupon'));
                        var discount = 0;
                        var totalAmount = parseFloat(cartTotal.text());
                        var cashBack = 0;

                        var charge = `
                                    ${baseSymbol}${parseFloat(row.fixed_charge)} ${(0 < row.percent_charge) ? ' + ' +parseFloat(row.percent_charge) + ' % ' : ''}`
                                    ;

                        var totalCharge = parseFloat(row.fixed_charge) + (parseFloat(totalAmount) * parseFloat(row.percent_charge) / 100);

                        if(coupon){

                            var notice = `<code> To get discount minimum order ${baseSymbol}${parseFloat(coupon.min_order_amount).toFixed(2)}</code>`;

                            if(coupon.type == 0){
                                discount = parseFloat(coupon.discount)+'%'+notice;
                            }
                            else{
                                discount = baseSymbol+parseFloat(coupon.discount)+notice;
                            }
                        }

                        var finalAmount = totalAmount + totalCharge;

                        if(discount != 0 && totalAmount >= coupon.min_order_amount){
                            if(coupon.type == 0){
                                cashBack = (parseFloat(totalAmount) * parseFloat(coupon.discount) / 100);
                                finalAmount = finalAmount - cashBack;
                            }
                            else{
                                cashBack = parseFloat(coupon.discount);
                                finalAmount = finalAmount - cashBack;
                            }
                        }

                        finalAmount = parseFloat(finalAmount);

                        var details =`
                            <h4 class="title mb-2">@lang('Payment Details')</h4>
                                <ul class="cart-info-list">
                                    <li><span class="caption">@lang('Total Order'):</span> <span class="value">
                                        ${baseSymbol}${totalAmount.toFixed(2)} ${ cashBack != 0 ? ' <code> ( Total Discount ' + baseSymbol + cashBack.toFixed(2) +' ) </code> ' : ''}
                                        </span>
                                    </li>
                                    <li><span class="caption">@lang('Discount'):</span> <span class="value">${discount}</span> </li>
                                    <li><span class="caption">@lang('Payment Method'):</span> <span class="value">${row.name}</span> </li>
                                    <li><span class="caption">@lang('Payment Charge'):</span> <span class="value">${charge}</span> </li>
                                    <li><span class="caption">@lang('Total Charge'):</span> <span class="value">${totalCharge.toFixed(2)}</span> </li>
                                    <li><span class="caption">@lang('Final Amount'):</span> <span class="value">${baseSymbol}${finalAmount.toFixed(2)}</span> </li>
                                </ul>
                            `;

                            $('.paymentDetails').html(details);

                    }else if(response.error){

                        $.each(response.error, function(key, value) {
                            notify('error', value);
                        });

                    }else{
                        notify('error', response.message)
                    }

                },
                error: function(error){
                    return;
                }
            });

        });

        $('.shipping-form').on('submit', function(e){
            e.preventDefault();

            $('#addCartModal').modal().show();

            $('.confirmBtn').on('click', function(){
                e.currentTarget.submit();
            });

        });

    })(jQuery);
</script>
@endpush

@push('style')
<style>
    body {
        counter-reset: section;
    }
    .cart-list-table tbody tr td:first-child::after {
        counter-increment: section;
        content: counter(section);
    }
    .cart-info-list {
        border: 1px solid #e5e5e5;
        border-radius: 5px
    }
    .cart-info-list li {
        display: flex;
        flex-wrap: wrap;
        padding: 6px 15px;
        border-bottom: 1px solid #e5e5e5;
    }
    .cart-info-list li:last-child {
        border-bottom: none;
    }
    .cart-info-list li .caption {
        width: 40%;
    }
    .cart-info-list li .value {
        width: 60%;
        font-weight: 600;
        color: #363636;
    }

    .config-color-list {
        justify-content: center;
    }

    @media (max-width: 420px) {
        .cart-info-list li .caption {
            width: 50%;
        }
    .cart-info-list li .value {
            width: 50%;
        }
    }
</style>
@endpush


