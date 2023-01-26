@php
    $footer = getContent('footer.content', true);
    $links = getContent('social_icon.element');
    $policyPages = getContent('policy_pages.element');
@endphp
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Footer
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<footer class="footer-section bg-overlay-white pt-80 bg_img" data-background="{{ getImage('assets/images/frontend/footer/' .@$footer->data_values->image, '1920x1080') }}">
    <div class="container">
        <div class="footer-top-area">
            <div class="row justify-content-center">
                <div class="col-xl-12 text-center">
                    <div class="footer-top-wrapper">
                        <div class="footer-logo">
                            <a href="{{ route('home') }}" class="logo"><img src="{{getImage(imagePath()['logoIcon']['path'] .'/logo.png')}}" alt="logo"></a>
                        </div>
                        <ul class="footer-links">
                            @foreach($policyPages as $singlePolicy)
                                <li>
                                    <a href="{{ route('policy.details', ['policy'=>slug($singlePolicy->data_values->title), 'id'=>$singlePolicy->id]) }}">
                                        {{ __($singlePolicy->data_values->title) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom-area">
            <div class="copyright-area d-flex flex-wrap align-items-center justify-content-between">
                <div class="copyright">
                    <p>{{ __(@$footer->data_values->text) }}</p>
                </div>
                <div class="social-area">
                    <ul class="footer-social text-center">
                        @foreach($links as $socialLink)
                            <li>
                                <a href="{{ $socialLink->data_values->url }}" target="_blank">
                                    @php
                                        echo $socialLink->data_values->social_icon;
                                    @endphp
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Footer
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
