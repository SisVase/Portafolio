@php
    $feature = getContent('feature.content', true);
    $features = getContent('feature.element');
@endphp
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Feature
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="feature-section pt-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-8 text-center">
                <div class="section-header">
                    <h2 class="section-title">{{ __(@$feature->data_values->heading) }}</h2>
                </div>
            </div>
        </div>
        <div class="feature-wrapper mb-80">
            <div class="row justify-content-center mb-30-none">
                @foreach($features as $singleFeature)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-30">
                        <div class="feature-item text-center">
                            <div class="feature-thumb">
                                <img src="{{ getImage('assets/images/frontend/feature/' .@$singleFeature->data_values->image, '56x56') }}" alt="feature">
                            </div>
                            <div class="feature-content">
                                <h4 class="title">{{ __($singleFeature->data_values->heading) }}</h4>
                                <p>
                                    {{ __($singleFeature->data_values->sub_heading) }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-7 text-center">
                <div class="feature-big-thumb">
                    <a href="#0"><img src="{{ getImage('assets/images/frontend/feature/' .@$feature->data_values->image, '56x56') }}" alt="drone"></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Feature
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
