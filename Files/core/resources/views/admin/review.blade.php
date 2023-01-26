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
                                <th>@lang('Name')</th>
                                <th>@lang('Remark')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($reviews as $data)
                            <tr>
                                <td data-label="@lang('Name')">
                                    <span class="font-weight-bold">
                                        {{ __($data->name) }}
                                    </span>
                                </td>
                                <td data-label="@lang('Remark')">
                                    {{ shortDescription($data->remark, 100) }}
                                </td>
                                <td data-label="@lang('Status')">
                                    @if($data->status == 1)
                                        <span class="badge badge--success">
                                            @lang('Approved')
                                        </span>
                                    @else
                                        <span class="badge badge--warning">
                                            @lang('Pending')
                                        </span>
                                    @endif
                                </td>

                                <td data-label="@lang('Action')">
                                    <a href="#" class="icon-btn editBtn" data-toggle="tooltip" title="" data-original-title="@lang('Status')"
                                    data-name="{{ $data->name }}"
                                    data-rating="{{ $data->rating }}"
                                    data-remark="{{ $data->remark }}"
                                    data-id="{{ $data->id }}"
                                    data-status='{{ $data->status }}'
                                    >
                                        <i class="las la-edit text--shadow"></i>
                                    </a>

                                    <a href="#" class="icon-btn deleteBtn bg--danger ml-2" data-toggle="tooltip" title="" data-original-title="@lang('Delete')"
                                    data-id="{{ $data->id }}"
                                    >
                                        <i class="las la-trash text--shadow"></i>
                                    </a>

                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}!</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ paginateLinks($reviews) }}
                </div>
            </div>
        </div>
    </div>

    {{-- STATUS METHOD MODAL --}}
    <div id="editModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Review')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.review.update') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 form-group">
                                <label class="font-weight-bold">@lang('Remark')</label> <span class="star"></span> @lang('Star')
                                <p class="name"></p>
                            </div>
                            <div class="col-lg-12 form-group">
                                <label class="font-weight-bold">@lang('Remark')</label>
                                <p class="remark"></p>
                            </div>
                            <input type="hidden" name="id">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="edit_status">@lang('Status')</label>
                                    <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" id="edit_status" data-on="@lang('Approve')" data-off="@lang('Pending')" name="status">
                                </div>
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

    {{-- DELETE METHOD MODAL --}}
    <div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Confirmation')!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.review.delete') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" required>
                    <div class="modal-body">
                        <p class="font-weight-bold text-center">@lang('Are you sure to delete')?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--danger">@lang('Confirm')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function ($) {
            "use strict";

            $('.editBtn').on('click', function () {
                var modal = $('#editModal');
                modal.find('.name').text($(this).data('name'));
                modal.find('input[name=id]').val($(this).data('id'));
                modal.find('.remark').text($(this).data('remark'));
                modal.find('.star').text($(this).data('rating'));

                if($(this).data('status') == 1){
                    modal.find('input[name=status]').bootstrapToggle('on');
                }else{
                    modal.find('input[name=status]').bootstrapToggle('off');
                }

                modal.modal('show');
            });

            $('.deleteBtn').on('click', function () {
                var modal = $('#deleteModal');
                modal.find('input[name=id]').val($(this).data('id'));
                modal.modal('show');
            });

        })(jQuery);
    </script>
@endpush
