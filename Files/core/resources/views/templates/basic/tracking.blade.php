@extends($activeTemplate.'layouts.frontend')

@php
    $track = getContent('track.content', true);
@endphp

@section('content')
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Tracking
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="tracking-section ptb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="tracking-area"> 
                    <div class="tracking-search-area">
                        <h4 class="title">{{ __(@$track->data_values->heading) }} <span class="m-0 pl-md-3">{{ __(@$track->data_values->sub_heading) }}</span></h4>
                    </div>
                    <form class="tracking-form" method="get">
                        <input type="text" name="search" class="form--control" value="{{ request('search') }}">
                        <button type="submit" class="submit-btn">@lang('Track')</button>
                    </form>
                    @if(@$order)
                        <div class="tracking-list-area">
                            <div class="tracking-list-inner w-100">
                                <div class="row"> 
                                    <div class="col-md-6 col-sm-8">
                                        <ul class="tracking-list">
                                            <li>{{ showDateTime(@$order->created_at) }}</li>
                                            <li>@lang('Invoice'): #{{ @$order->id }}</li>
                                            <li>@lang('Tracking Code'): {{ @$order->track_id }}</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6 col-sm-4 my-sm-0 my-4 flex-end">
                                        <div class="text-sm-right text-left">
                                            <h3 class="payment">{{ $general->cur_sym }}{{ showAmount($order->final_price, 2) }}</h3>
                                            @if(@$order->status == 1)
                                                <span class="badge badge--warning">@lang('Pending')</span>
                                            @elseif(@$order->status == 2)
                                                <span class="badge badge--info">@lang('Processing')</span>
                                            @elseif(@$order->status == 3)
                                                <span class="badge badge--primary">@lang('Shipping')</span>
                                            @elseif(@$order->status == 4)
                                                <span class="badge badge--success">@lang('Delivered')</span>
                                            @elseif(@$order->status == 5)
                                                <span class="badge badge--danger">@lang('Payment Pending')</span>
                                            @elseif(@$order->status == 6)
                                                <span class="badge badge--dark">@lang('Rejected')</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <ul class="tracking-list">
                                    <li><span>@lang('Name'):</span> {{ __(@$order->name) }}</li>
                                    <li><span>@lang('Email'):</span> {{ __(@$order->email) }}</li>
                                    <li><span>@lang('Phone'):</span> {{ @$order->phone }}</li>
                                </ul>
                                @if(@$order->shipping_address != null && gettype($order->shipping_address) == 'object')
                                <h5 class="mt-5">@lang('Shipping Address')</h5>
                                    <ul class="tracking-list">
                                        @foreach(@$order->shipping_address as $data)
                                            <li>{{ inputTitle($data->field_name) }}: {{ __($data->field_value) }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                        @if(@$order->tracks->count() > 0 )
                            <div class="tracking-updates-area">
                                <h4 class="title">@lang('Tracking Updates')</h4>
                                <div class="timeline timeline-single-column">
                                    @foreach($order->tracks as $track)
                                        <div class="timeline-item complete">
                                            <div class="timeline-time">
                                                <p>{{ showDateTime($track->date, 'M d') }}</p>
                                                <p>{{ showDateTime($track->date, 'h:i a') }}</p>
                                            </div>
                                            <div class="timeline-point blk-point"></div>
                                            <div class="timeline-event">
                                                <p>{{ __($track->info) }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endif

                    @if(request('search') && !$order)
                        <div class="tracking-list-area">
                            <div class="tracking-list-inner">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                       <h4 class="title">@lang('Sorry, Order not found')!</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="tracking-list-area">
                            <div class="tracking-list-inner">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                    <h4 class="title">@lang('Please enter your Order Tracking ID')</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Tracking
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@endsection

