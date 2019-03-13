<html>
    <head>
        <link rel="stylesheet" href="{{ mix('css/web_launcher.css') }} ">
    </head>
    <body>
        <div class="wrapper">
            <div class="menu">
                <ul>
                    <li><a href="{{ route('front.home') }}" target="_blank">Trang chủ</a></li>
                    <li><a href="{{ route('front.static.nap_the_cao') }}" target="_blank">Nạp Thẻ</a></li>
                    <li><a href="{{ config('site.fb.page_url') }}" target="_blank">Fanpage</a></li>
                    <li><a href="{{ route('front.static.nap_the_cao') }}" target="_blank">Đăng ký</a></li>
                </ul>
            </div>
            @foreach($slides as $slide)
                <div class="img">
                    <a href="{{ $slide->link }}" title="{{ $slide->title }}" target="_blank">
                        <img src="{{ Voyager::image($slide->image) }}" alt="{{ $slide->title }}"/>
                    </a>
                </div>
             @endforeach
            <div class="list-new">
                <ul>
                    @foreach($newsByCategory as $categorySlug => $news)
                        @foreach($news as $item)
                        <li>
                            <a href="{{ route('front.details.post', [$categorySlug, $item->slug]) }} target="_blank" ">
                                {{ str_limit($item->title, 30) }} <span class="time">{{ $item->displayPublishedDate()}}</span>
                            </a>
                        </li>
                        @endforeach
                    @endforeach
                    
                </ul>
            </div>
        </div>
    </body>
</html>