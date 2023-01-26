@extends($activeTemplate.'layouts.frontend')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center text-center">
        <div class="col-md-8">
            <div class="card custom--card">
                <div class="card-header">
                    <h3 class="title">@lang('Payment Preview')</h3>
                </div>
                <div class="card-body card-body-deposit text-center">
                    <h4 class="my-2"> @lang('PLEASE SEND EXACTLY') <span class="text-success"> {{ $data->amount }}</span> {{__($data->currency)}}</h4>
                    <h5 class="mb-2">@lang('TO') <span class="text-success"> {{ $data->sendto }}</span></h5>
                    <img src="{{$data->img}}" alt="@lang('Image')">
                    <h4 class="text-white bold my-4">@lang('SCAN TO SEND')</h4>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

