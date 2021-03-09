<html>
    <head>
        <link rel="stylesheet" href="{{ staticUrl('css/reset.css', true) }} ">
        <link rel="stylesheet" href="{{ staticUrl('css/web_launcher_2021.css', true) }} ">
    </head>
    <body>
        <div class="wrapper">
            <div class="list-new">
                <ul>
                    @foreach($posts as $item)
                    <li>
                        <img src="../images/icon-laucher.png" class="icon-laucher">
                        <a href="{{ route('front.details.post', [$item->getCategorySlug(), $item->slug] ) }}"
                           title="Xem Thêm" target="_blank">
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