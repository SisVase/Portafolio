@extends('admin.layouts.app')
@section('panel')
<div class="row mb-none-30">
    <div class="col-xl-4 col-md-6 mb-30">
        <div class="card b-radius--10 overflow-hidden box--shadow1">

            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    @if($invoice->status == 1)
                        <span class="badge badge--warning">@lang('Pending')</span>
                    @elseif($invoice->status == 2)
                        <span class="badge badge--info">@lang('Processing')</span>
                    @elseif($invoice->status == 3)
                        <span class="badge badge--primary">@lang('Shipping')</span>
                    @elseif($invoice->status == 4)
                        <span class="badge badge--success">@lang('Delivered')</span>
                    @elseif($invoice->status == 5)
                        <span class="badge badge--danger">@lang('Payment Pending')</span>
                    @elseif($invoice->status == 6)
                        <span class="badge badge--dark">@lang('Rejected')</span>
                    @endif
                </div>
                <form action="{{ route('admin.order.status.update') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" required value="{{ $invoice->id }}">
                    <div class="row">
                        <div class="col-lg-6 form-group"> 
                            <select name="status" class="form-control">
                                <option value="1" {{ $invoice->status == 1 ? 'selected' : null }}>@lang('Pending')</option>
                                <option value="2" {{ $invoice->status == 2 ? 'selected' : null }}>@lang('Processing')</option>
                                <option value="3" {{ $invoice->status == 3 ? 'selected' : null }}>@lang('Shipping')</option>
                                <option value="4" {{ $invoice->status == 4 ? 'selected' : null }}>@lang('Delivered')</option>
                            </select>
                        </div>
                        <div class="col-lg-6 form-group">
                            <button type="submit" class="btn btn--primary w-100" {{ $invoice->status == 4 ? 'disabled' : null }}>@lang('Update')</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-body">
                <h5 class="mb-20 text-muted">@lang('Customer Info')</h5>
                <ul class="list-group mb-4">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang('Name')
                        <span class="font-weight-bold">{{ __($invoice->name) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang('Email')
                        <span class="font-weight-bold">{{ __($invoice->email) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang('Phone')
                        <span class="font-weight-bold">{{ __($invoice->phone) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang('Ordered At')
                        <span class="font-weight-bold">{{ showDateTime($invoice->created_at) }}</span>
                    </li>
                </ul>
                @lang('Payment Details') <a href="{{ route('admin.deposit.details', $invoice->deposit->id) }}">@lang('View Details')</a>
            </div>

            <div class="card-body">
                <h5 class="mb-20 text-muted">@lang('Orders Info')</h5>
                <ul class="list-group mb-4">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang('Invoice')<span class="font-weight-bold">#{{ __($invoice->id) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        @lang('Track Id')<span class="font-weight-bold">{{ __($invoice->track_id) }}</span>
                    </li>
                    @foreach($invoice->orders as $index => $order)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ __($order->qty) }}   @lang('Pcs')
                        <div>
                            {{ __($order->size) }} 
                            @if($order->color)
                                <div style="background: #{{ __($order->color) }}; height:20px; width:20px;"></div>
                            @else 
                                <div>@lang('N/A')</div>
                            @endif
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>

            @if($invoice->shipping_address != null && gettype($invoice->shipping_address) == 'object')
                <div class="card-body">
                    <h5 class="mb-20 text-muted">@lang('Shipping Info')</h5>
                    <ul class="list-group mb-4">
                        @foreach($invoice->shipping_address as $data)
                            @if($data->type == 'text')
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ inputTitle($data->field_name) }}
                                    <span class="font-weight-bold">
                                        {{ __($data->field_value) }}
                                    </span>
                                </li>
                            @else
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="font-weight-bold">
                                        <p>{{ inputTitle($data->field_name) }}</p>
                                        {{ __($data->field_value) }}
                                    </span>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endif

        </div>
    </div>
    <div class="col-xl-8 col-md-6 mb-30">
        <div class="card b-radius--10">
            <div class="card-body p-0">
                <div class="table-responsive--md  table-responsive">
                    <table class="table table--light style--two">
                        <thead>
                        <tr>
                            <th>@lang('Date')</th>
                            <th>@lang('Info')</th>
                            <th>@lang('Action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($tracks as $data)
                        <tr>
                            <td data-label="@lang('Date')">
                                {{ showDateTime($data->created_at) }}
                                <br>
                                {{ diffForHumans($data->created_at) }}
                            </td>

                            <td data-label="@lang('Info')">
                                <span class="font-weight-bold">{{ __($data->info) }}</span>
                                <br>
                                <code>@lang('Shipping'): </code>{{ showDateTime($data->date) }} {{ diffForHumans($data->date) }}
                            </td>

                            <td data-label="@lang('Action')">
                                <a href="javascript:void(0)" class="icon-btn ml-2 update" data-id="{{ $data->id }}" data-info="{{ $data->info }}" data-toggle="tooltip" title="" data-original-title="@lang('Update')" data-shipping="">
                                    <i class="las la-edit text--shadow"></i>
                                </a>
                                <a href="javascript:void(0)" data-id="{{ $data->id }}" class="icon-btn ml-2 bg--danger delete" data-toggle="tooltip" title="" data-original-title="@lang('Delete')">
                                    <i class="las la-trash text--shadow"></i>
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
                {{ paginateLinks($tracks) }}
            </div>
        </div>
    </div>
</div>

<div id="shippingModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Add New Shipping')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.order.track.add') }}" method="POST">
                @csrf
                <input type="hidden" name="id" required value="{{ $invoice->id }}">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="info">@lang('Shipping Info')</label>
                            <input type="text" name="info" id="info" class="form-control" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="date">@lang('Date')</label>
                            <input type="datetime-local" name="date" id="date" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--primary">@lang('Save')</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Delete Shipping Info')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.order.track.delete') }}" method="POST">
                @csrf
                <input type="hidden" name="invoice_id" required value="{{ $invoice->id }}">
                <input type="hidden" name="id" required>
                <div class="modal-body">
                    <p class="text-center font-weight-bold">@lang('Are you sure to delete this')?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--danger">@lang('Delete')</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="updateModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Update Shipping')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.order.track.update') }}" method="POST">
                @csrf
                <input type="hidden" name="invoice_id" required value="{{ $invoice->id }}">
                <input type="hidden" name="id" required>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="info">@lang('Shipping Info')</label>
                            <input type="text" name="info" id="info" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--primary">@lang('Update')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('breadcrumb-plugins')
<a href="{{ route('admin.order.all') }}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="la la-fw fa-backward"></i>@lang('Go To Orders')</a>
<a href="javascript:void(0)" class="btn btn-sm btn--primary box--shadow1 text--small shipping"><i class="la la-fw fa-plus"></i>@lang('Add New')</a>
@endpush


@push('script')
    <script>

    (function($){

        "use strict";

        $('.shipping').on('click', function () {
            var modal = $('#shippingModal');
            modal.modal('show');
        });

        $('.delete').on('click', function () {
            var modal = $('#deleteModal');
            modal.find('input[name=id]').val($(this).data('id'));
            modal.modal('show');
        })

        $('.update').on('click', function () {
            var modal = $('#updateModal');
            modal.find('input[name=id]').val($(this).data('id'));
            modal.find('input[name=info]').val($(this).data('info'));
            modal.modal('show');
        })

    })(jQuery);

    </script>
@endpush


