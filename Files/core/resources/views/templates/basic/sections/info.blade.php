@php
    $allInfo = getContent('info.element');
@endphp
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Info
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="info-section bg--base ptb-30">
    <div class="container">
        <div class="row justify-content-center mb-30-none">
            @foreach($allInfo as $info)
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-30">
                    <div class="info-item text-white d-flex flex-wrap justify-content-center align-items-center">
                        <div class="info-icon">
                            @php
                                echo $info->data_values->icon;
                            @endphp
                        </div>
                        <div class="info-content">
                            <h4 class="text-white">{{ __($info->data_values->heading) }}</h4>
                            <p>{{ __($info->data_values->sub_heading) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Info
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
