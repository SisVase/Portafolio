@extends($activeTemplate.'layouts.frontend')

@section('content')
<section class="ptb-80">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                @php
                    echo $content->data_values->details;
                @endphp
            </div>
        </div>
    </div>
</section>
@endsection
