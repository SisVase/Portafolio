@php
    $action = getContent('action.content', true);
@endphp
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Action
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="action-section section--bg ptb-120 bg_img" data-background="{{ getImage('assets/images/frontend/action/' .@$action->data_values->image, '1920x1080') }}">
    <div class="container">
        <div class="row">
            <div class="col-xl-4 col-lg-4">
                <div class="action-content">
                    <h2 class="title">{{ __(@$action->data_values->heading) }}</h2>
                    <p>{{ __(@$action->data_values->sub_heading) }}</p>
                    <div class="action-btn mt-40">
                        <a href="{{ @$action->data_values->button_url }}" class="btn--base">{{ __(@$action->data_values->button_text) }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Action
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
