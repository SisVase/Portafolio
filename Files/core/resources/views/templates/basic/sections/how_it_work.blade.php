@php
    $work = getContent('how_it_work.content', true);
    $works = getContent('how_it_work.element');
@endphp
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start How It Works
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="how-work-section ptb-80">
    <div class="container">
        <div class="row justify-content-center mb-30-none">
            <div class="col-xl-4 mb-30">
                <div class="how-work-left-content">
                    <h2 class="title">{{ __(@$work->data_values->heading) }}</h2>
                    <p>{{ __(@$work->data_values->sub_heading) }}</p>
                    <div class="how-work-btn mt-40">
                        <a href="{{ @$work->data_values->button_url }}" class="btn--base">{{ __(@$work->data_values->button_text) }}</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-7 offset-xl-1 col-lg-7 mb-30">
                <div class="how-work-thumb-area">
                    <div class="how-work-thumb">
                        <a href="#0">
                            <img src="{{ getImage('assets/images/frontend/how_it_work/' .@$work->data_values->image, '465x335') }}" alt="drone">
                        </a>
                    </div>

                    @foreach($works as $singleWork)
                        <div class="how-work-content content-{{ $loop->index + 1 }}">
                            <h4 class="title">{{ __($singleWork->data_values->heading) }}</h4>
                            <p>{{ __($singleWork->data_values->sub_heading) }}</p>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End How It Works
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
