@extends('layouts.front')
@php
$activeSlug = $post->getCategorySlug();
/** @var \T2G\Common\Models\Post $post */
@endphp

@section('content')
    <div class="details-content">
        <div class="header-details-content">
            @if($post->hasGroup() && count($groupPosts) > 0)
                <p class="c-white">{{ $post->group_name }}</p>
                {!! Breadcrumbs::render('postGroup', $post) !!}
            @else
                <p class="c-white">{{ $post->title }}</p>
                {!! Breadcrumbs::render('post', $post) !!}
            @endif
        </div>
        <div class="main-details-content">
            @if($post->hasGroup() && count($groupPosts) > 0)
            <ul class="menu-news">
                @foreach($groupPosts as $item)
                    <li>
                        @if(empty($item['subs']))
                        <a class="tab-link {{ $item['post']->id == $post->id ? 'active' : '' }}"
                           title="{{ $item['post']->group_title }}"
                           href="{{ route('front.details.post', [$item['post']->getCategorySlug(), $item['post']->slug]) }}">{{ $item['post']->group_title }}</a>
                       @else
                        <a class="tab-link has-subs"
                           href="javascript:"
                           title="{{ $item['sub_title'] }}"
                           data-group="{{ $item['sub_title'] }}">{{ $item['sub_title'] }}</a>
                       @endif
                    </li>
                @endforeach
            </ul>
            @endif
            @if($post->hasGroup() && count($groupPosts) > 0)
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
            <div class="post-body">
                {!! $post->body !!}
            </div>
            <div class="ps">
                <img src="{{ asset('images/ps-icon.png') }}" alt="" height="20" width="20">
                &nbsp; Võ Lâm Trung Nguyên &nbsp;
                <img src="{{ asset('images/ps-icon.png') }}" alt="" height="20" width="20"><br/>
                Kính Bút!
            </div>
            @if(!$post->hasGroup() && count($others))
                <div class="view-more">
                    <ul>
                        @foreach($others as $other)
                            <li>
                                <a href="{{ route('front.details.post', [$other->getCategorySlug(), $other->slug]) }}">
                                    {{ str_limit($other->title, 100) }} <span>{{ $other->displayPublishedDate() }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('schemas')
    @include('t2g_common::schemas.post')
@endpush

@push('extra-js')
<script>
    $(document).ready(() => {
        $('.menu-news a').hover(function(e) {
            if ($(this).hasClass('has-subs')) {
                $('.menu-subs ul[data-group="'+ $(this).data('group') +'"]').addClass('active');
            } else {
                $('.menu-subs ul').removeClass('active');
            }
        });
    });
</script>
@endpush
