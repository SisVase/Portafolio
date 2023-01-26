@extends('admin.layouts.app')
@section('panel')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <form action="{{ route('admin.product.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="payment-method-item">
                        <div class="payment-method-body">
                            <div class="row">
                                <div class="col-lg-6 col-xl-4">
                                    <div class="card border--primary mt-3 height">
                                        <h5 class="card-header bg--primary">@lang('Name, Size & Color')</h5>
                                        <div class="card-body">
                                            <div class="input-group mb-3">
                                                <label class="w-100 font-weight-bold">
                                                    <label for="name">@lang('Product Name')*</label>
                                                </label>
                                                <input type="text" name="name" class="form-control" id="name" value="{{ __(@$product->name) }}" required>
                                            </div>
                                            <div class="input-group mb-3">
                                                <label class="w-100 font-weight-bold">
                                                    @lang('Select Size')
                                                </label>
                                                <select name="size[]" class="form-control select2-auto-tokenize" multiple>
                                                    @if(gettype(@$product->size) == 'array')
                                                        @foreach($product->size as $size)
                                                            <option value="{{ $size }}" selected>{{ $size }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="input-group mb-3">
                                                <label class="w-100 font-weight-bold justify-content-between d-flex">
                                                    @lang('Select Color')
                                                    <span class="btn btn-success btn-sm newColor">@lang('Add New')</span>
                                                </label>
                                                <select name="color[]" class="form-control select2-basic" multiple>
                                                    @if(gettype(@$product->color) == 'array') 
                                                        @foreach($product->color as $data)
                                                            <option value="{{ $data->code }}" selected>{{ $data->color }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-xl-4">
                                    <div class="card border--primary mt-3 height">
                                        <h5 class="card-header bg--primary">@lang('Pricing & Status')</h5>
                                        <div class="card-body">
                                            <div class="input-group mb-3">
                                                <label class="w-100 font-weight-bold">
                                                    @lang('Price') <span class="text-danger">*</span>
                                                    <strong class="disPrice"></strong>
                                                </label>
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">{{ __($general->cur_sym) }}</div>
                                                </div>
                                                <input type="text" class="form-control price" placeholder="0" name="price" value="{{ getAmount(@$product->price ?? 0, 2) }}"/ required>
                                            </div>
                                            <div class="input-group mb-3">
                                                <label class="w-100 font-weight-bold">@lang('Discount')</label>
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">@lang('%')</div>
                                                </div>
                                                <input type="text" class="form-control discount" placeholder="0" name="discount" value="{{ @$product->discount == 0 ? old('discount') : getAmount($product->discount, 2) }}">
                                                <div class="input-group-append calculate">
                                                    <div class="input-group-text btn btn--primary">@lang('Calculate')</div>
                                                </div>
                                            </div>
                                            <div class="input-group">
                                                <label for="status">@lang('Status')</label>
                                                <input type="checkbox" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-toggle="toggle" id="status" data-on="@lang('Enable')" data-off="@lang('Disable')" name="status" @if(@$product->status) checked @endif>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-xl-4">
                                    <div class="card border--primary mt-3 height">
                                        <h5 class="card-header bg--primary">@lang('Short Description')</h5>
                                        <div class="card-body">
                                            <div class="input-group mb-3">
                                                <textarea name="short_description" cols="30" rows="10" class="form-control" required>{{ __(@$product->short_description) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="card border--primary mt-3">
                                        <h5 class="card-header bg--primary  text-white">@lang('Product Iamge')
                                            <button type="button" class="btn btn-sm btn-outline-light float-right addImage"><i class="la la-fw la-plus"></i>@lang('Add New')
                                            </button>
                                        </h5>
                                        <div class="card-body">
                                            <div class="payment-method-header imageField">
                                                @foreach($images as $data)
                                                    <div class="thumb">
                                                        <div class="avatar-preview">
                                                            <div class="profilePicPreview" style="background-image: url('{{getImage(imagePath()['product']['path'].'/'.$data->image,imagePath()['product']['size'])}}')"></div>
                                                        </div>
                                                        <div class="avatar-edit">
                                                            <input type="file" name="image[]" class="profilePicUpload" id="image{{ $data->image }}" accept=".png, .jpg, .jpeg"/>
                                                            <label class="bg--danger removeImage" data-id="{{ $data->id }}"><i class="la la-trash"></i></label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <div class="card border--primary mt-3">

                                        <h5 class="card-header bg--primary">@lang('Description')</h5>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <textarea rows="8" class="form-control border-radius-5 nicEdit" name="description">{{ @$product->description }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn--primary btn-block">@lang('Update')</button>
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
                <h5 class="modal-title">@lang('Confirmation')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.product.image.delete') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="" required>
                <div class="modal-body">
                   <p class="font-weight-bold text-center">@lang('Are you sure to delete this image')?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn--danger">@lang('Confirm')</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- COLOR METHOD MODAL --}}
<div id="colorModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Add New Color')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.product.add.color') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="name">@lang('Color Name')</label>
                            <input type="text" name="name" class="form-control" id="name">
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="code" class="form-control-label"> @lang('Color Code')</label>
                            <div class="input-group">
                            <span class="input-group-addon">
                                <input type='text' class="form-control form-control-lg colorPicker" value="{{$general->base_color}}"/>
                            </span>
                                <input type="text" class="form-control form-control-lg colorCode" name="code" id="code">
                            </div>
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
@endsection

@push('script-lib')
    <script src="{{ asset('assets/admin/js/spectrum.js') }}"></script>
@endpush

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/spectrum.css') }}">
@endpush

@push('script')
    <script>
        (function ($) {
            "use strict";

            var imagesArray = @json( json_decode(@$product->images) );

            $('.imageArray').val(imagesArray);

            if(@json(@$product->discount) != 0 ){
                var currency = @json($general->cur_text);
                $('.disPrice').text(`Discount Price @json($afterDiscount) ${currency}`);
            }

            $('.addImage').on('click', function () {

                var uniqueId = Math.random() * 100;

                var html = `
                        <div class="thumb">
                            <div class="avatar-preview">
                                <div class="profilePicPreview d-flex align-items-center justify-content-center" style="background-image: url('')">
                                    <span>@lang('Multiple Image Upload')</span>
                                </div>
                            </div>
                            <div class="avatar-edit">
                                <input type="file" name="image[]" class="profilePicUpload" id="${uniqueId}" accept=".png, .jpg, .jpeg"/ required multiple>
                                <label class="bg--danger removeBtn"><i class="la la-trash"></i></label>
                                <label for="${uniqueId}" class="bg--primary"><i class="la la-pencil"></i></label>
                            </div>{{ imagePath()['product']['size'] }}
                        </div>
                   `;
                $('.imageField').append(html);
            });

            $(document).on('click', '.removeBtn', function () {

                var imageName = $(this).data('image');

                if(typeof imageName === 'undefined'){
                    return $(this).parent().parent().remove();
                }

                var index = imagesArray.indexOf(imageName);

                imagesArray.splice(index, 1);

                $(this).parent().parent().remove();

                $('.imageArray').val(imagesArray);
            });

            $('.price').on('input', function () {
                var input = $(this).val();
                var discount = $('.discount');

                if(input){
                    discount.prop('readonly', false);
                }else{
                    discount.val('');
                    $('.disPrice').text('');
                    $('.discount').prop('readonly', true);
                }
            });

            $('.calculate').on('click', function () {

                var discount = parseFloat($('.discount').val());
                var disArea = $('.disPrice');

                if(!discount){
                    return disArea.text('');
                }

                var price = parseFloat($('.price').val());
                var afterDiscount = (discount/100) * price;
                var currency = @json($general->cur_text);

                disArea.text(`Discount Price ${price - afterDiscount} ${currency}`);
            });

            $('.removeImage').on('click', function () {
                var modal = $('#deleteModal');
                modal.find('input[name=id]').val($(this).data('id'));
                modal.modal('show');
            });

            $('.newColor').on('click', function () {
                var modal = $('#colorModal');
                modal.modal('show');
            });

            $('.colorPicker').spectrum({
                color: $(this).data('color'),
                change: function (color) {
                    $(this).parent().siblings('.colorCode').val(color.toHexString().replace(/^#?/, ''));
                }
            });

            $('.colorCode').on('input', function () {
                var clr = $(this).val();
                $(this).parents('.input-group').find('.colorPicker').spectrum({
                    color: clr,
                });
            });

        })(jQuery);
    </script>
@endpush


@push('style')
<style>
    .profilePicPreview.has-image > span {
        display: none;
    }
    .height{
        height: calc(100% - 1rem);
    }
    .sp-replacer {
            padding: 0;
            border: 1px solid rgba(0, 0, 0, .125);
            border-radius: 5px 0 0 5px;
            border-right: none;
        }

        .sp-preview {
            width: 100px;
            height: 46px;
            border: 0;
        }

        .sp-preview-inner {
            width: 110px;
        }

        .sp-dd {
            display: none;
        }
        .select2-container .select2-selection--single {
            height: 44px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 43px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 43px;
        }
</style>
@endpush
