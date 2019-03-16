@php
    $guideSlug = 'huong-dan';
@endphp
<div class="newbies">
    <div class="newbies-header">
        <div class="newbies-title f-left">Hướng dẫn tân thủ</div>
        <div class="newbies-more f-right">
            <a href="{{ route('front.category', [$guideSlug]) }}"></a>
        </div>
    </div>

    @if(count($guides))
        @php
            /** @var \Illuminate\Support\Collection $guides */
                $firstItem = $guides->shift();
        @endphp
        <div class="hot-news">
            <a class="h-news-tt" title="Xem thêm"
               href="{{ route('front.details.post', [$guideSlug, $firstItem->slug] ) }}">
                <div class="hot-img f-left">
                    <img src="{{ Voyager::image($firstItem->getImage()) }}" onerror="if (this.src != '/images/hot-img.png') this.src = '/images/logo.png';"
                         alt="{{ $firstItem->title }}">
                </div>
                <div class="hot-des f-left">
                    <p class="hot-title">{{ str_limit($firstItem->title, 100) }}</p>
                    <p>{{ str_limit($firstItem->excerpt, 100) }}</p>
                </div>
                <div class="hot-time f-right"><p>{{ $firstItem->displayPublishedDate()}}</p></div>
            </a>
        </div>
        @if(count($guides))
            <div class="list-news">
                <ul>
                    @foreach($guides as $item)
                        <li>
                            <a href="{{ route('front.details.post', [$guideSlug, $item->slug]) }}">
                                {{ str_limit($item->title, 100) }} <span>{{ $item->displayPublishedDate()}}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    @endif
</div>
