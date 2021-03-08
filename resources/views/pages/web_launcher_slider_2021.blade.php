<html>
    <head>
        <link rel="stylesheet" href="{{ staticUrl('css/web_launcher_2021.css', true) }} ">
    </head>
    <body>
        <div class="wrapper-slider">
            @if(!empty($slides))
                <section class="slider">
                    @foreach($slides as $slide)
                        <div class="image-slider">
                            <a href="{{ route('front.details.post', [$slide->getCategorySlug(), $slide->slug] )  }}" target="_blank" title="{{ $slide->title }}"><img src="{{ Voyager::image($slide->image) }}" alt="{{ $slide->title }}"></a>
                        </div>
                    @endforeach
                </section>
            @endif
        </div>
        <script type="text/javascript" src="{{ staticUrl('js/web_laucher.js', true) }}"></script>
    </body>
</html>