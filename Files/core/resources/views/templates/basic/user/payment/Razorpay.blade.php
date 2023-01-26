@extends($activeTemplate.'layouts.frontend')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center text-center">
            <div class="col-xl-5 col-lg-6 col-md-10">
                <div class="card custom--card">
                    <div class="card-header">
                    <h3 class="title"><span>@lang('Razorpay payment')</span></h3>
                    </div>
                    <div class="card-body">
                        <img src="{{$deposit->gatewayCurrency()->methodImage()}}" class="card-img-top" alt="@lang('Image')" class="w-100">
                        <h3 class="text-center mt-4">@lang('Please Pay') {{showAmount($deposit->final_amo)}} {{$deposit->method_currency}}</h3>
                        <form action="{{$data->url}}" method="{{$data->method}}">
                            <input type="hidden" custom="{{$data->custom}}" name="hidden">
                            <script src="{{$data->checkout_js}}"
                                    @foreach($data->val as $key=>$value)
                                    data-{{$key}}="{{$value}}"
                                @endforeach >
                            </script>
                        </form>
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
            $('input[type="submit"]').addClass("ml-4 mt-4 bg--base w-auto");
        })(jQuery);
    </script>
@endpush
