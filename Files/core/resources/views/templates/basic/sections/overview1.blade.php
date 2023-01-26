@php
    $overviewOne = getContent('overview1.content', true);
    $overviewsOne = getContent('overview1.element');
@endphp
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Overview
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="overview-section ptb-80">
    <div class="container">
        <div class="row justify-content-center align-items-center mb-30-none">
            <div class="col-xl-6 col-lg-6 mb-30">
                <div class="overview-content">
                    <h2 class="title">{{ __(@$overviewOne->data_values->heading) }}</h2>
                    <p>{{ __(@$overviewOne->data_values->sub_heading) }}</p>
                    <div class="overview-item-area mt-30">
                        <div class="row mb-30-none">
                            @foreach ($overviewsOne as $singleRow)
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 mb-30">
                                    <div class="overview-item">
                                        <div class="overview-icon">
                                            <img src="{{ getImage('assets/images/frontend/overview1/' .@$singleRow->data_values->image, '51x51') }}" alt="icon">
                                        </div>
                                        <div class="overview-details">
                                            <h2 class="title">{{ __($singleRow->data_values->heading) }}</h2>
                                            <span class="sub-title">{{ __($singleRow->data_values->sub_heading) }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="overview-btn mt-50">
                        <a href="{{ @$overviewOne->data_values->button_url }}" class="btn--base">{{ __(@$overviewOne->data_values->button_text) }}</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 mb-30">
                <div class="overview-thumb">
                    <a href="#0"><img src="{{ getImage('assets/images/frontend/overview1/' .@$overviewOne->data_values->image, '595x290') }}" alt="overview"></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Overview
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
