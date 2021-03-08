<html>
    <head>
        <link rel="stylesheet" href="{{ staticUrl('css/web_launcher_2021.css') }} ">
    </head>
    <body>
        <div class="wrapper">
            <div class="list-new">
                <ul>
                    @foreach($posts as $item)
                    <li>
                        <div class="wrapper-icons">
                            <span class="icon-laucher"></span>
                            <a href="{{ route('front.details.post', [$item->getCategorySlug(), $item->slug] ) }}" title="Xem Thêm" target="_blank">
                                {{ str_limit($item->title, 30) }}
                            </a>
                        </div>
                        <span class="time">[{{ $item->displayPublishedDate()}}]</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </body>
</html>