@extends($activeTemplate.'layouts.frontend')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
            <div class="widget__ticket">
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                    <h6 class="widget__ticket-title mb-4 me-2">
                    @if($my_ticket->status == 0)
                        <span class="badge badge--success py-2 px-3 mb-2">@lang('Open')</span>
                    @elseif($my_ticket->status == 1)
                        <span class="badge badge--primary py-2 px-3 mb-2">@lang('Answered')</span>
                    @elseif($my_ticket->status == 2)
                        <span class="badge badge--warning py-2 px-3 mb-2">@lang('Replied')</span>
                    @elseif($my_ticket->status == 3)
                        <span class="badge badge--dark py-2 px-3 mb-2">@lang('Closed')</span>
                    @endif
                    [@lang('Ticket')#{{ $my_ticket->ticket }}] {{ $my_ticket->subject }}
                    </h6>
                    
                    <button class="text--danger mb-4 bg-transparent" type="button" title="@lang('Close Ticket')" data-toggle="modal" data-target="#DelModal"><i class="fas fa-lg fa-times"></i>
                        </button>
                </div>
                <div class="message__chatbox__body">
                    @if($my_ticket->status != 4)
                        <form method="post" class="message__chatbox__form row" action="{{ route('ticket.reply', $my_ticket->id) }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="replayTicket" value="1">
                            <div class="form--group col-sm-12">
                                <textarea name="message" class="form-control form--control bg--body" id="inputMessage" placeholder="@lang('Your Reply')"></textarea>
                            </div>
                            <div class="form--group col-sm-12">
                                <div class="d-flex">
                                    <div class="left-group col p-0 pr-4">

                                        <label for="inputAttachments" class="form--label text--title">@lang('Attachments')</label>
                                        <input type="file" name="attachments[]" id="inputAttachments" class="form-control form--control mb-2"/>
                                        <div id="fileUploadsContainer"></div>
                                        <p class="info">
                                            @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'), .@lang('pdf'), .@lang('doc'), .@lang('docx')
                                        </p>

                                    </div>
                                    <div class="add-area">
                                        <label class="form--label text--title d-block">&nbsp;</label>
                                        <button class="cmn--btn btn--sm bg--primary ms-2 ms-md-4 form--control addFile" type="button"><i class="las la-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="form--group col-sm-12 mb-0">
                                <button type="submit" class="cmn--btn">@lang('Reply')</button>
                            </div>
                        </form> 
                    @endif
                </div>
            </div>
                <div class="widget__ticket">
                    <ul class="message__chatbox__body">
                        @foreach($messages as $message)
                            @if($message->admin_id == 0)
                                <li>
                                    <div class="reply-item">
                                        <div class="name-area">
                                            <h5 class="title">{{ $message->ticket->name }}</h5>
                                        </div>
                                        <div class="content-area">
                                            <span class="meta-date">
                                                <span class="text--dark">@lang('Posted on')</span> <span class="text--base">{{ $message->created_at->format('l, dS F Y @ H:i') }}</span></span>
                                            <p>{{$message->message}}</p>
                                            @if($message->attachments()->count() > 0)
                                            <div class="mt-2">
                                                @foreach($message->attachments as $k=> $image)
                                                    <a href="{{route('ticket.download',encrypt($image->id))}}" class="mr-3"><i class="fa fa-file"></i>  @lang('Attachment') {{++$k}} </a>
                                                @endforeach
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @else
                                <li>
                                    <div class="reply-item ml-3 ml-sm-4 ml-md-5" style="background: #7349f21a">
                                        <div class="name-area">
                                            <h5 class="title">{{ $message->admin->name }}</h5>
                                            <p class="info text-muted">@lang('Staff')</p>
                                        </div>
                                        <div class="content-area">
                                            <span class="meta-date">
                                                <span class="text--dark">@lang('Posted on')</span> <span class="text--base">{{ $message->created_at->format('l, dS F Y @ H:i') }}</span></span>
                                            <p>{{$message->message}}</p>
                                            @if($message->attachments()->count() > 0)
                                            <div class="mt-2">
                                                @foreach($message->attachments as $k=> $image)
                                                    <a href="{{route('ticket.download',encrypt($image->id))}}" class="mr-3"><i class="fa fa-file"></i>  @lang('Attachment') {{++$k}} </a>
                                                @endforeach
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="DelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('ticket.reply', $my_ticket->id) }}">
                    @csrf
                    <input type="hidden" name="replayTicket" value="2">
                    <div class="modal-header">
                        <h5 class="modal-title"> @lang('Confirmation')!</h5>
                        <button type="button" class="close close-button" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <strong class="text-dark">@lang('Are you sure you want to close this support ticket')?</strong>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--lg rounded py-2 text-white bg--danger btn-sm" data-dismiss="modal"><i class="las la-times"></i>
                            @lang('Close')
                        </button>
                        <button type="submit" class="btn btn--lg rounded py-2 text-white bg--success btn-sm"><i class="fa fa-check"></i> @lang("Confirm")
                        </button>
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
            $('.delete-message').on('click', function (e) {
                $('.message_id').val($(this).data('id'));
            });
            $('.addFile').on('click',function(){
                $("#fileUploadsContainer").append(
                    `<div class="input-group input--group">
                        <input type="file" name="attachments[]" class="form-control form--control mb-3" required />
                        <div class="input-group-append support-input-group mt-0 mb-2">
                            <span class="input-group-text bg--base cmn--btn btn--danger remove-btn py-2">x</span>
                        </div>
                    </div>`
                )
            });
            $(document).on('click','.remove-btn',function(){
                $(this).closest('.input-group').remove();
            });
        })(jQuery);

    </script>
@endpush
