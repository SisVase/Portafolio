@php
    $blog = getContent('blog.content', true);

    if(request()->routeIs('home')){
        $blogs = getContent('blog.element', false, 3, false);
    }else{
        $blogs = App\Models\Frontend::where('data_keys', 'blog.element')->latest()->paginate(getPaginate());
    }

@endphp
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Blog
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="blog-section ptb-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-8 text-center">
                <div class="section-header">
                    <h2 class="section-title">{{ __(@$blog->data_values->heading) }}</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mb-30-none">
            @foreach($blogs as $singleBlog)
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 mb-30">
                    <div class="blog-item">
                        <div class="blog-thumb">
                            <img src="{{ getImage('assets/images/frontend/blog/' .@$singleBlog->data_values->image, '1920x1080') }}" alt="@lang('blog')">
                        </div>
                        <div class="blog-content">
                            <h4 class="title">
                            <a href="{{ route('blog.details', ['slug'=>slug($singleBlog->data_values->title), 'id'=>$singleBlog->id]) }}">
                                {{ shortDescription($singleBlog->data_values->title, 100) }}
                            </a>
                            </h4>
                            <p>{{ shortDescription($singleBlog->data_values->short_description, 200) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="justify-content-center d-flex mt-5">
            @if(!request()->routeIs('home'))
                {{ $blogs->links() }}
            @endif
        </div>

    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Blog
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
