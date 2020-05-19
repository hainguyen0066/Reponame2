@php
    $categories = \App\Util\Helper::getNewsCategories();
    $i = 0;
@endphp
<div class="news">
    <div class="column-first">
        <div class="menu-news">
            @foreach($categories as $categorySlug => $categoryName)
                <div class="tab-link sprite {{ $categorySlug }} {{ $i++ == 0 ? 'active' : '' }}"
                     data-tab="{{ $categorySlug }}"
                     data-link="{{ route('front.category', [$categorySlug]) }}">{{ $categoryName }}</div>
            @endforeach
            <a href="{{ route('front.category', ['tong-hop']) }}" title="Xem thêm" class="news-more"></a>
        </div>
        @php
            $i = 0;
        @endphp
        @foreach($newsByCategory as $categorySlug => $news)
            @php
                $active = $i == 0 ? 'active' : '';
                $i++;
            @endphp
            <div class="tab-content {{ $categorySlug }}-content {{ $active }}">
            @if(count($news))
                @php
                    /** @var \Illuminate\Support\Collection $news */
                        $firstItem = $news->shift();
                @endphp
                <div class="tab-content {{ $categorySlug }}-content {{ $active }}">
                    <div class="hot-news">
                        <a class="h-news-tt" title="Xem thêm"
                           href="{{ route('front.details.post', [$firstItem->getCategorySlug(), $firstItem->slug] ) }}">
                            <div class="hot-img f-left">
                                <img src="{{ $firstItem->getImage() }}"  onerror="if (this.src != '/images/logo.png') this.src = '/images/logo.png';"
                                     alt="{{ $firstItem->title }}">
                            </div>
                            <div class="hot-des f-left">
                                <p class="hot-title">{{ str_limit($firstItem->title, 100) }}</p>
                                <p>{{ str_limit($firstItem->excerpt, 100) }}</p>
                            </div>
                            <div class="hot-time f-right"><p>{{ $firstItem->displayPublishedDate()}}</p></div>
                        </a>
                    </div>
                    @if(count($news))
                    <div class="list-news">
                        <ul>
                            @foreach($news as $item)
                            <li>
                                <a href="{{ route('front.details.post', [$item->getCategorySlug(), $item->slug]) }}">
                                    {{ str_limit($item->title, 100) }} <span>{{ $item->displayPublishedDate()}}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            @endif
            </div>
        @endforeach
    </div>
    <div class="column-second sprite"></div>
    <div class="clearfix"></div>
</div>
