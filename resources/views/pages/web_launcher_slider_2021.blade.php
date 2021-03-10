<html>
    <head>
        <link rel="stylesheet" href="{{ staticUrl('css/reset.css', true) }} ">
        <link rel="stylesheet" href="{{ staticUrl('css/slick-theme.css', true) }} ">
        <link rel="stylesheet" href="{{ staticUrl('css/slick.css', true) }} ">
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.0/jquery.min.js" integrity="sha512-K7Zj7PGsHk2fpY3Jwvbuo9nKc541MofFrrLaUUO9zqghnJxbZ3Zn35W/ZeXvbT2RtSujxGbw8PgkqpoZXXbGhw==" crossorigin="anonymous"></script>
        <script type="text/javascript" src="{{ staticUrl('js/launcher/slick.js', true) }}"></script>
        <script type="text/javascript" src="{{ staticUrl('js/launcher/web_laucher.js', true) }}"></script>
    </body>
</html>