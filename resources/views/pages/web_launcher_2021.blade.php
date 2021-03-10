<html>
    <head>
        <link rel="stylesheet" href="{{ asset('css/reset.css') }}?v={{ config('t2g_common.asset.version') }}">
        <link rel="stylesheet" href="{{ asset('css/web_launcher_2021.css') }}?v={{ config('t2g_common.asset.version') }}">
    </head>
    <body>
        <div class="wrapper">
            <div class="list-new">
                <ul>
                    @foreach($posts as $item)
                    <li>
                        <img src="../images/icon-laucher.png" class="icon-laucher">
                        <a href="{{ route('front.details.post', [$item->getCategorySlug(), $item->slug] ) }}"
                           target="_blank" title="Xem Thêm" >
                            {{ str_limit($item->title, 30) }}
                        </a>
                        <span class="time">[{{ $item->displayPublishedDate()}}]</span>
                        <div class="clearfix"></div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </body>
</html>
