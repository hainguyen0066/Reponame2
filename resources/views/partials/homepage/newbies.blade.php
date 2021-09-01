@php
    $categories = \App\Util\Helper::getNewsCategories();
    $viewMoreSlug = '';
    $i = 0;
@endphp
<div class="newbies">
    <div class="newbies-header">
        @foreach(array_keys($featuredPosts) as $i => $featureName)
            @php
                $slug = str_slug($featureName);
                if ($i == 0) {
                    $viewMoreSlug = $slug;
                }
            @endphp
            <div class="newbies-title sprite f-left {{ $slug }} {{ $i++ == 0 ? 'active' : '' }}"
                 data-tab="{{ $slug }}" data-link="{{ route('front.post.group', [$slug]) }}">
                {{ $featureName }}
            </div>
        @endforeach
    </div>
    @php
        $i = 0;
    @endphp
    @foreach($featuredPosts as $featureName => $groupPosts)
        @php
            $active = $i == 0 ? 'active' : '';
            $i++;
            $slug = str_slug($featureName);
        @endphp
        <div class="tab-content {{ $slug }}-content {{ $active }}">
            @if(count($groupPosts))
                @php
                    /** @var \Illuminate\Support\Collection $groupPosts */
                        $firstItem = $groupPosts->shift();
                @endphp
                <div class="tab-content {{ $slug }}-content {{ $active }}">
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
                            <div class="hot-time f-right"><p>{{  \App\Util\Helper::displayUpdatedDate($firstItem) }}</p></div>
                        </a>
                    </div>
                    @if(count($groupPosts))
                        <div class="list-news">
                            <ul>
                                @foreach($groupPosts as $item)
                                    <li>
                                        <a href="{{ route('front.details.post', [$item->getCategorySlug(), $item->slug]) }}">
                                            {{ str_limit($item->title, 100) }} <span>{{  \App\Util\Helper::displayUpdatedDate($item) }}</span>
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
