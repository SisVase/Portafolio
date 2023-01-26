@php
    $video = getContent('video.content', true);
@endphp
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Video
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="video-section bg_img" data-background="{{ getImage('assets/images/frontend/video/' .@$video->data_values->image, '1920x1080') }}">
    <a class="video-icon" data-rel="lightcase:myCollection" href="{{ @$video->data_values->embed_link }}">
        <i class="fas fa-play"></i>
    </a>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Video
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
