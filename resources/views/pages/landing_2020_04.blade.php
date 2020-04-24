<!DOCTYPE html>
<html lang="vi" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=1920, initial-scale=1">
    @component('meta')
        @slot('title')
        @section('title'){{ $title ?? config('t2g_common.site.seo.title') }}@show
        @endslot
        @slot('meta_description')
            {{ $meta_description ?? config('t2g_common.site.seo.meta_description') }}
        @endslot
        @slot('meta_keywords')
            {{ $meta_keywords ?? config('t2g_common.site.seo.meta_keyword') }}
        @endslot
        @slot('meta_image')
            {{ $meta_image ?? asset(config('t2g_common.site.seo.meta_image')) }}
        @endslot
    @endcomponent
    <link rel="stylesheet" href="{{ mix('css/landing-2020-04.css') }}">
    <link rel="stylesheet" href="{{ mix('css/account.css') }}">
    @include('t2g_common::schemas.home')
</head>
<body>
@php
$cacheBuster = "?v=" . config('t2g_common.asset.version');
@endphp
    <div class="wrapper">
        <a href="javascript:" class="icon-scroll" title="Scroll xuống để xem tiếp">Scroll xuống để xem tiếp</a>
        <section class="section-01">
            <video id="intro" autoplay loop muted>
                <source src="{{ asset('images/landing-2020-04/landing_page.mp4') }}" type="video/mp4">
            </video>
            <div class="container">
                {{--<div class="logo"><a href="{{ route('front.home')}}"></a></div>--}}
                <div class="menu">
                    <ul>
                        <li><a href="{{ route('front.home')}}">Trang chủ</a></li>
                        <li><a href="{{ config('site.fb.page_url') }}" target="_blank">Fanpage</a></li>
                        <li><a href="{{ config('site.fb.group_url')}}" target="_blank">Group</a></li>
                    </ul>
                </div>
                <div class="three-button">
                    @if(!$user)
                    <a class="register-btn account-register sprite" title="Đăng ký"></a>
                    @endif
                    <a class="download {{ $user ? 'logged' : '' }} sprite"
                       href="{{ route('front.page.download')}}" title="Tải game"></a>
                </div>
            </div>
        </section>
        <section class="section-02" data-bg="{{ asset('images/landing-2020-04/bg-f2-h.jpg') . $cacheBuster  }}"></section>
        <section class="section-03" data-bg="{{ asset('images/landing-2020-04/bg-f3-h.jpg') . $cacheBuster  }}">
            <div class="container">
                <div class="download"> <a class="sprite" href="{{ route('front.page.download')}}"></a></div>
            </div>
        </section>
        <section class="section-04" data-bg="{{ asset('images/landing-2020-04/bg-f4-h.jpg') . $cacheBuster  }}">
            <div class="container">
                <div class="download"> <a class="sprite" href="{{ route('front.page.download')}}"></a></div>
            </div>
        </section>
        <section class="section-05" data-bg="{{ asset('images/landing-2020-04/bg-f5-h.jpg') . $cacheBuster  }}">
            <div class="container">
                <div class="frame-button volamtranhba sprite">
                    <a href="{{ route('front.details.post', ['su-kien','dua-top-level-100'])}}"><span>&nbsp;</span></a>
                </div>
                <div class="frame-button quanhunghoitu sprite">
                    <a href="{{ route('front.details.post', ['su-kien','quan-hung-hoi-tu-khai-mo-may-chu-bien-kinh']) }}"><span>&nbsp;</span></a>
                </div>
                <div class="frame-button anhhungthiep sprite">
                    <a href="{{ route('front.details.post', ['su-kien','anh-hung-thiep-khai-mo-may-chu-bien-kinh']) }}"><span>&nbsp;</span></a>
                </div>
                <div class="clearfix"></div>
                <a href="javascript:" id="goTop" class="sprite">Go top</a>
            </div>
        </section>
        <footer>
            <p>Bản quyền &copy;2019 Phát hành duy nhất tại: <span>vltrungnguyen.com</span></p>
            <p>Địa chỉ: 21 Nguyễn Thái Học, phường Bến Nghé, Quận 1, Thành phố Hồ Chí Minh</p>
            <p>Điện thoại: <span>0898 002 151</span> Fanpage : <a href="{{ config('site.fb.page_url') }}" target="blank" title="Fanpage">{{ config('site.fb.page_url') }}</a></p>
        </footer>
    </div>
@include('partials.trackers')
@if(!$user)
    @include('modal.account')
@endif
@section('js')
    <script>
        window.user_id = '{{ \Auth::check() ? \Auth::user()->id : '' }}';
    </script>
    <script type="text/javascript" src="{{ mix('js/landing-2020-04.js') }}"></script>
@show
@include('partials.tracker.fb_chat')
</body>
</html>
