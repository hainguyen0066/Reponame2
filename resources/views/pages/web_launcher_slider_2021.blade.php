<html>
<head>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }} ">
    <link rel="stylesheet" href="{{ asset('css/slick-theme.css') }} ">
    <link rel="stylesheet" href="{{ asset('css/slick.css') }} ">
    <link rel="stylesheet" href="{{ asset('css/web_launcher_2021.css') }} ">
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
<script type="text/javascript" src="{{ asset('js/launcher/jquery-3.5.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/launcher/slick.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/launcher/web_laucher.js') }}"></script>
</body>
</html>
