@if($post->hasGroup() && count($groupPosts) > 0)
    <ul class="menu-news">
        @foreach($groupPosts as $item)
            <li class="{{ $item['post']->id == $post->id ? 'active' : '' }}">
                @if(empty($item['subs']))
                    <a class="tab-link {{ $item['post']->id == $post->id ? 'active' : '' }}"
                       title="{{ $item['post']->group_title }}"
                       href="{{ route('front.details.post', [$item['post']->getCategorySlug(), $item['post']->slug]) }}">{{ ucwords($item['post']->group_title) }}</a>
                @else
                    <a class="tab-link has-subs"
                       href="javascript:"
                       title="{{ $item['sub_title'] }}"
                       data-group="{{ $item['sub_title'] }}">{{ ucwords($item['sub_title']) }}</a>
                @endif
            </li>
        @endforeach
    </ul>
    <div class="menu-subs">
        @foreach($groupPosts as $item)
            @if(!empty($item['subs']))
                <ul data-group="{{ $item['sub_title'] }}">
                    @foreach($item['subs'] as $subItem)
                        @php
                            $activeClass = $subItem->id == $post->id ? 'active' : '';
                        @endphp
                        <li class="{{ $activeClass }}">
                            <a href="{{ route('front.details.post', [$subItem->getCategorySlug(), $subItem->slug]) }}"
                               title="{{ $subItem->group_title }}"
                            >
                                {{ $subItem->group_title }}
                            </a>
                        </li>
                        @if(!empty($activeClass))
                            @push('extra-js')
                                <script>
                                    activeSub = $('.menu-subs li.active');
                                    activeSub.parent().addClass('active');
                                    $('.menu-news .tab-link[data-group="'+ activeSub.parent().data('group') +'"]').addClass('active');
                                </script>
                            @endpush
                        @endif
                    @endforeach
                    <div class="clearfix"></div>
                </ul>
            @endif
        @endforeach
    </div>
@endif
