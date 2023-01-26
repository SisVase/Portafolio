@extends($activeTemplate.'layouts.frontend')
@section('content')
    <div class="container py-5">
        <div class="row justify-content-center text-center">
            <div class="col-xl-5 col-lg-6 col-md-10">
                <div class="card custom--card">
                    <div class="card-header">
                        <h3 class="card-title text-white">@lang('Stripe Payment')</h3>
                    </div>
                    <div class="card-body">
                        <img src="{{$deposit->gatewayCurrency()->methodImage()}}" class="card-img-top" alt="@lang('Image')" class="w-100">
                        <form action="{{$data->url}}" method="{{$data->method}}" class="mt-4">
                            <h3 class="text-center">@lang('Please Pay') {{showAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}</h3>
                            <script src="{{$data->src}}"
                                class="stripe-button"
                                @foreach($data->val as $key=> $value)
                                data-{{$key}}="{{$value}}"
                                @endforeach
                            >
                            </script>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        (function ($) {
            "use strict";
            $('.stripe-button-el').addClass("btn bg--base text-white").removeClass('stripe-button-el');
        })(jQuery);
    </script>
@endpush
