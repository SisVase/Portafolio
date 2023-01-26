@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>@lang('Tracking Id')</th>
                                <th>@lang('Email-Phone')</th>
                                <th>@lang('Amount')</th>
                                <th>@lang('Price')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($invoices as $data)
                            <tr>
                                <td data-label="@lang('Tracking Id')">
                                    <span class="font-weight-bold">{{$data->track_id}}</span>
                                    <br>
                                    {{ showDateTime($data->created_at) }} - {{ diffForHumans($data->created_at) }}
                                </td>

                                <td data-label="@lang('Email-Phone')">
                                    {{ $data->email }}<br>{{ $data->phone }}
                                </td>

                                <td data-label="@lang('Amount')">
                                    @lang('Charge') - <span class="font-weight-bold">{{ $general->cur_sym }}{{ showAmount($data->charge, 2) }}</span>
                                    <br>
                                    @lang('Discount') - <span class="font-weight-bold">{{ $general->cur_sym }}{{ showAmount($data->discount, 2) }}</span>
                                </td>

                                <td data-label="@lang('Price')">
                                    @lang('Order Price') - <span class="font-weight-bold">{{ $general->cur_sym }}{{ showAmount($data->price, 2) }}</span>
                                    <br>
                                    @lang('Final Price') - <span class="font-weight-bold">{{ $general->cur_sym }}{{ showAmount($data->final_price, 2) }}</span>
                                </td>

                                <td data-label="@lang('Status')">
                                    @if($data->status == 1)
                                        <span class="badge badge--warning">@lang('Pending')</span>
                                    @elseif($data->status == 2)
                                        <span class="badge badge--info">@lang('Processing')</span>
                                    @elseif($data->status == 3)
                                        <span class="badge badge--primary">@lang('Shipping')</span>
                                    @elseif($data->status == 4)
                                        <span class="badge badge--success">@lang('Delivered')</span>
                                    @elseif($data->status == 5)
                                        <span class="badge badge--danger">@lang('Payment Pending')</span>
                                    @elseif($data->status == 6)
                                        <span class="badge badge--dark">@lang('Rejected')</span>
                                    @endif
                                </td>

                                <td data-label="@lang('Action')">
                                    <a href="{{ route('admin.deposit.details', $data->deposit->id) }}" class="icon-btn ml-1" data-toggle="tooltip" title="" data-original-title="@lang('Payment')">
                                        <i class="las la-money-bill-wave-alt text--shadow"></i>
                                    </a>

                                    @if($data->shipping_address)
                                        <a href="#" class="icon-btn shipping ml-1" data-toggle="tooltip" title="" data-original-title="@lang('Shipping')" data-shipping="{{ json_encode($data->shipping_address) }}">
                                            <i class="las la-shipping-fast text--shadow"></i>
                                        </a>
                                    @endif

                                    <a href="{{ route('admin.order.details', $data->id) }}" class="icon-btn ml-1" data-toggle="tooltip" title="" data-original-title="@lang('Details')">
                                        <i class="las la-desktop text--shadow"></i>
                                    </a>
                                </td>

                            </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ paginateLinks($invoices) }}
                </div>
            </div>
        </div>
    </div>

    <div id="shippingModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Shipping Address')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="POST">

                    <div class="modal-body details">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('breadcrumb-plugins')
    <form action="" method="GET" class="form-inline float-sm-right bg--white">
        <div class="input-group has_append">
            <input type="text" name="search" class="form-control" placeholder="@lang('Tracking ID')" value="{{ request('search') ?? '' }}">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
@endpush


@push('script')
    <script>

    (function($){

        "use strict";

        $('.shipping').on('click', function () {
            var modal = $('#shippingModal');

            var list = [];
            var details =  Object.entries($(this).data('shipping'));
            var singleInfo = '';

            for (var i = 0; i < details.length; i++) {
                singleInfo += `<div class="col-md-12">
                                    <label class='font-weight-bold' style='text-transform: capitalize;'>${details[i][0].replaceAll('_', " ")}</label>
                                    <p>${details[i][1].field_value}</p>
                                </div>`;

            }

            if(singleInfo){
                modal.find('.details').html(`${singleInfo}`);
            }else{
                modal.find('.details').html(`<p class='font-weight-bold text-center'>@lang('Data Not Found')!</p>`);
            }

            modal.modal('show');
        });

    })(jQuery);

    </script>
@endpush


