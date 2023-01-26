@extends($activeTemplate.'layouts.frontend')

@section('content')
<section class="blog-section ptb-80">
    <div class="container">
        <div class="row justify-content-center mb-30-none">
            <div class="col-xl-8 mb-30">
                <div class="blog-item">
                    <div class="blog-thumb">
                        <img src="{{ getImage('assets/images/frontend/blog/' .@$blog->data_values->image, '1920x1080') }}" alt="blog">
                    </div>
                    <div class="blog-content">
                        <h3 class="title">{{ __($blog->data_values->title) }}</h3>
                        <p>{{ __($blog->data_values->short_description) }}</p>
                        <p>@php echo $blog->data_values->description_nic; @endphp</p>
                    </div>
                </div>
                <div class="blog-social-area d-flex flex-wrap justify-content-between align-items-center">
                    <h3 class="title">@lang('Share This Post')</h3>
                    <ul class="blog-social">
                        <li>
                            <a href="https://www.facebook.com/sharer/sharer.php?=u{{ url()->current() }}" target="_blank">
                                <i class="lab la-facebook-f"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://twitter.com/home?status={{ url()->current() }}" target="_blank">
                                <i class="lab la-twitter"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ url()->current() }}" target="_blank">
                                <i class="lab la-linkedin-in"></i>
                            </a>
                        </li>
                        <li>
                            <a href="http://www.reddit.com/submit?url={{ url()->current() }}" target="_blank">
                                <i class="lab la-reddit"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="fb-comments" data-href="{{ route('blog.details', ['slug'=>slug($blog->data_values->title), 'id'=>$blog->id]) }}" data-numposts="5"></div>
            </div>
            <div class="col-xl-4 mb-30">
                <div class="sidebar">
                    <div class="widget-box mb-30">
                        <h5 class="widget-title">@lang('Latest Posts')</h5>
                        <div class="popular-widget-box">
                            @foreach($latestBlogs as $latestBlogs)
                                <div class="single-popular-item d-flex flex-wrap align-items-center">
                                    <div class="popular-item-thumb">
                                        <img src="{{ getImage('assets/images/frontend/blog/' .@$latestBlogs->data_values->image, '1920x1080') }}" alt="blog">
                                    </div>
                                    <div class="popular-item-content">
                                        <a href="{{ route('blog.details', ['slug'=>slug($latestBlogs->data_values->title), 'id'=>$latestBlogs->id]) }}">
                                            <h5 class="title">{{ shortDescription($latestBlogs->data_values->title, 45) }}</h5>
                                        </a>
                                        <span class="blog-date">{{ showDateTime($latestBlogs->created_at, 'd M Y') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('fbComment')
	@php echo loadFbComment() @endphp
@endpush

@push('share')
<meta property="og:type" content="website">
<meta property="og:title" content="{{ $blog->data_values->title }}">
<meta property="og:image" content="{{ getImage('assets/images/frontend/blog/' .@$blog->data_values->image, '1920x1080') }}"/>
<meta property="og:image:type" content="image/{{ pathinfo(getImage('assets/images/frontend/blog/') .'/'. @$blog->data_values->image)['extension'] }}" />
@php $social_image_size = explode('x', '750x500') @endphp
<meta property="og:image:width" content="{{ $social_image_size[0] }}" />
<meta property="og:image:height" content="{{ $social_image_size[1] }}" />
@endpush
