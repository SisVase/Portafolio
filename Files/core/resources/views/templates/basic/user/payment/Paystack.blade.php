@extends($activeTemplate.'layouts.frontend')
@section('content')
    <div class="container py-5">
        <div class="row justify-content-center text-center">
            <div class="col-xl-5 col-lg-6 col-md-10">
                <div class="card custom--card">
                    <div class="card-header">
                        <h3 class="title"><span>@lang('Payment Preview')</span></h3>
                    </div>
                    <div class="card-body py-4">
                        <img src="{{$deposit->gatewayCurrency()->methodImage()}}" class="card-img-top mb-4" alt="@lang('Image')" class="w-100">
                        <form action="{{ route('ipn.'.$deposit->gateway->alias) }}" method="POST" class="text-center">
                            @csrf
                            <h3>@lang('Please Pay') {{showAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}</h3>
                            <button type="button" class=" mt-4 btn-success btn-round bg--base text-center btn-lg" id="btn-confirm">@lang('Pay Now')</button>
                            <script
                                src="//js.paystack.co/v1/inline.js"
                                data-key="{{ $data->key }}"
                                data-email="{{ $data->email }}"
                                data-amount="{{$data->amount}}"
                                data-currency="{{$data->currency}}"
                                data-ref="{{ $data->ref }}"
                                data-custom-button="btn-confirm"
                            >
                            </script>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
