@extends($activeTemplate.'layouts.frontend')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center text-center">
            <div class="col-xl-5 col-lg-6 col-md-10">
                <div class="card custom--card">
                    <div class="card-header">
                        <h3 class="title m-0"><span>@lang('Payment Preview')</span></h3>
                    </div>
                    <div class="card-body py-4">
                        <img src="{{$deposit->gatewayCurrency()->methodImage()}}" class="card-img-top mb-4" alt="@lang('Image')" class="w-100">
                        <h3>@lang('Please Pay') {{showAmount($deposit->final_amo)}} {{__($deposit->method_currency)}}</h3>
                        <button type="button" class="btn bg--base mt-4 btn-custom2 " id="btn-confirm" onClick="payWithRave()">@lang('Pay Now')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
    <script>
        "use strict"
        var btn = document.querySelector("#btn-confirm");
        btn.setAttribute("type", "button");
        const API_publicKey = "{{$data->API_publicKey}}";

        function payWithRave() {
            var x = getpaidSetup({
                PBFPubKey: API_publicKey,
                customer_email: "{{$data->customer_email}}",
                amount: "{{$data->amount }}",
                customer_phone: "{{$data->customer_phone}}",
                currency: "{{$data->currency}}",
                txref: "{{$data->txref}}",
                onclose: function () {
                },
                callback: function (response) {
                    var txref = response.tx.txRef;
                    var status = response.tx.status;
                    var chargeResponse = response.tx.chargeResponseCode;
                    if (chargeResponse == "00" || chargeResponse == "0") {
                        window.location = '{{ url('ipn/flutterwave') }}/' + txref + '/' + status;
                    } else {
                        window.location = '{{ url('ipn/flutterwave') }}/' + txref + '/' + status;
                    }
                        // x.close(); // use this to close the modal immediately after payment.
                    }
                });
        }
    </script>
@endpush
