<html>
<head>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}?v={{ config('t2g_common.asset.version') }}">
    <link rel="stylesheet" href="{{ asset('css/slick-theme.css') }}?v={{ config('t2g_common.asset.version') }}">
    <link rel="stylesheet" href="{{ asset('css/slick.css') }}?v={{ config('t2g_common.asset.version') }}">
    <link rel="stylesheet" href="{{ asset('css/web_launcher_2021.css') }}?v={{ config('t2g_common.asset.version') }}">
</head>
<body>
<div class="wrapper-slider">
    @if(!empty($slides))
        <section class="slider">
            @foreach($slides as $slide)
                <div class="image-slider">
                    <a href="{{ route('front.details.post', [$slide->getCategorySlug(), $slide->slug] )  }}"
                       target="_blank" title="{{ $slide->title }}">
                        <img src="{{ Voyager::image($slide->image) }}" alt="{{ $slide->title }}"/>
                    </a>
                </div>
            @endforeach
        </section>
    @endif
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.0/jquery.min.js" integrity="sha512-K7Zj7PGsHk2fpY3Jwvbuo9nKc541MofFrrLaUUO9zqghnJxbZ3Zn35W/ZeXvbT2RtSujxGbw8PgkqpoZXXbGhw==" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('js/launcher/slick.js') }}?v={{ config('t2g_common.asset.version') }}"></script>
<script type="text/javascript" src="{{ asset('js/launcher/web_laucher.js') }}?v={{ config('t2g_common.asset.version') }}"></script>
</body>
</html>
