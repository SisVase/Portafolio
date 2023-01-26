@extends($activeTemplate.'layouts.frontend')

@php
    $contact = getContent('contact_us.content', true);
    $contacts = getContent('contact_us.element');
@endphp

@section('content')
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Contact
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="contact-section pt-80">
    <div class="container">
        <div class="contact-area"> 
            <div class="row justify-content-center mb-30-none">
                <div class="col-lg-4 mb-30">
                    <div class="contact-info-item-area mb-40-none">
                        <div class="contact-info-header mb-30">
                            <h3 class="header-title">{{ __(@$contact->data_values->heading) }}</h3>
                        </div>
                        @foreach($contacts as $singleContact)
                            <div class="contact-info-item d-flex flex-wrap align-items-center mb-40">
                                <div class="contact-info-icon">
                                    @php
                                        echo $singleContact->data_values->icon;
                                    @endphp
                                </div>
                                <div class="contact-info-content">
                                    <h3 class="title">{{ __($singleContact->data_values->address_title) }}</h3>
                                    <p>{{ __($singleContact->data_values->address) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-8 mb-30">
                    <div class="contact-form-area">
                        <h3 class="title">{{ __(@$contact->data_values->sub_heading) }}</h3>
                        <form class="contact-form" method="post" action="">
                            @csrf
                            <div class="row justify-content-center mb-10-none">
                                <div class="col-lg-6 form-group">
                                    <input type="text" name="name" class="form-control" placeholder="@lang('Your Name')" value="{{ old('name') }}" required>
                                </div>
                                <div class="col-lg-6 form-group">
                                    <input type="email" name="email" class="form-control" placeholder="@lang('Your Email')" value="{{ old('email') }}" required>
                                </div>
                                <div class="col-lg-6 form-group">
                                    <input type="text" name="phone" class="form-control" placeholder="@lang('Phone')" value="{{ old('phone') }}" required>
                                </div>
                                <div class="col-lg-6 form-group">
                                    <input type="text" name="subject" class="form-control" placeholder="@lang('Subject')" value="{{ old('subject') }}" required>
                                </div>
                                <div class="col-lg-12 form-group">
                                    <textarea class="form-control" placeholder="@lang('Your Message')" name="message">{{old('message')}}</textarea>
                                </div>
                                <div class="col-lg-12 form-group">
                                    <button type="submit" class="submit-btn">@lang('Send Message')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Contact
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Map
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div class="map-section ptb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="maps"></div>
            </div>
        </div>
    </div>
</div>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Map
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@endsection

@push('script-lib')
<script src="https://maps.google.com/maps/api/js?key=AIzaSyCo_pcAdFNbTDCAvMwAD19oRTuEmb9M50c"></script>
<script src="{{asset($activeTemplateTrue.'js/map.js')}}"></script>

<script>

  var mapOptions = {
    center: new google.maps.LatLng( {{ @$contact->data_values->map_latitude }} , {{ @$contact->data_values->map_longitude }}),
    zoom: 12,
    styles: styleArray,
    scrollwheel: true,
    backgroundColor: 'transparent',
      mapTypeControl: true,          
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  var map = new google.maps.Map(document.getElementsByClassName("maps")[0],
    mapOptions);        
  var myLatlng = new google.maps.LatLng( {{ @$contact->data_values->map_latitude }} , {{ @$contact->data_values->map_longitude }});
  var focusplace = {lat:  {{ @$contact->data_values->map_latitude }}  , lng: {{ @$contact->data_values->map_longitude }} };      
  var marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
      icon: {
          url: "{{asset($activeTemplateTrue.'images/map-marker.png')}}"
      }
  })
</script>

@endpush

