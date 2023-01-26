@php
    $overViewTwo = getContent('overview2.content', true);
    $overViewsTwo = getContent('overview2.element');
@endphp
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Overview
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="overview-section bg--gray ptb-80">
    <div class="container">
        <div class="row justify-content-center align-items-center mb-30-none">
            <div class="col-xl-6 col-lg-6 mb-30">
                <div class="overview-thumb">
                    <a href="#0"><img src="{{ getImage('assets/images/frontend/overview2/' .@$overViewTwo->data_values->image, '1045x575') }}" alt="overview"></a>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 mb-30">
                <div class="overview-content">
                    <h2 class="title">{{ __(@$overViewTwo->data_values->heading) }}</h2>
                    <p>{{ __(@$overViewTwo->data_values->sub_heading) }}</p>
                    <div class="overview-item-area mt-30">
                        <div class="row mb-30-none">
                            <div class="col-xl-12 col-lg-12 mb-30">
                                @foreach($overViewsTwo as $singleItem)
                                    <div class="overview-item mb-20">
                                        <div class="overview-icon">
                                            <img src="{{ getImage('assets/images/frontend/overview2/' .@$singleItem->data_values->image, '23x38') }}" alt="icon">
                                        </div>
                                        <div class="overview-details">
                                            <span class="sub-title">{{ __($singleItem->data_values->heading) }}</span>
                                            <h3 class="title">{{ __($singleItem->data_values->sub_heading) }}</h3>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="overview-btn mt-40">
                        <a href="{{ @$overViewTwo->data_values->button_url }}" class="btn--base">{{ __(@$overViewTwo->data_values->button_text) }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Overview
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
