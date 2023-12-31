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
    <link rel="stylesheet" href="{{ mix('css/landing-2019-11.css') }}">
    <link rel="stylesheet" href="{{ mix('css/account.css') }}">
    @include('t2g_common::schemas.home')
</head>
<body>
@php
$cacheBuster = "?v=" . config('t2g_common.asset.version');
@endphp
    <div class="wrapper">
        <section class="section-01" data-bg="{{ asset('images/landing-2019-11/bg-frame1-high.jpg') . $cacheBuster  }}">
            <div class="container">
                <div class="logo"><a href="{{ route('front.home')}}"></a></div>
                <div class="menu">
                    <ul>
                        <li><a href="{{ route('front.home')}}">Trang chủ</a></li>
                        <li><a href="{{ config('site.fb.page_url') }}" target="_blank">Fanpage</a></li>
                        <li><a href="{{ config('site.fb.group_url')}}" target="_blank">Group</a></li>
                    </ul>
                </div>
                <div class="three-button">
                    @if(!$user)
                    <a class="register-btn account-register" title="Đăng ký"></a>
                    @endif
                    <a class="download {{ $user ? 'logged' : '' }}"
                       href="{{ route('front.page.download')}}" title="Tải game"></a>
                    @if(!$user)
                    <a class="login-btn account-login" title="Đăng nhập"></a>
                    @endif
                </div>
            </div>
        </section>
        <section class="section-02" data-bg="{{ asset('images/landing-2019-11/bg-frame2-high.jpg') . $cacheBuster  }}"></section>
        <section class="section-03" data-bg="{{ asset('images/landing-2019-11/bg-frame3-high.jpg') . $cacheBuster  }}">
            <div class="container">
                <div class="download"> <a href="{{ route('front.page.download')}}"></a></div>
            </div>
        </section>
        <section class="section-04" data-bg="{{ asset('images/landing-2019-11/bg-frame4-high.jpg') . $cacheBuster  }}">
            <div class="container">
                <div class="download"> <a href="{{ route('front.page.download')}}"></a></div>
            </div>
        </section>
        <section class="section-05" data-bg="{{ asset('images/landing-2019-11/bg-frame5-high.jpg') . $cacheBuster  }}">
            <div class="container">
                <div class="frame-button volamtranhba"><a href="{{ route('front.details.post', ['tong-hop','su-kien-dua-top-may-chu-nam-nhac-tran'])}}"></a></div>
                <div class="frame-button quanhunghoitu"><a href="{{ route('front.details.post', ['tong-hop','chuoi-su-kien-closebeta-nam-nhac-tran-may-chu-thu-phi']) }}"></a></div>
                <div class="frame-button anhhungthiep"><a href="{{ route('front.details.post', ['tong-hop','chuoi-su-kien-closebeta-nam-nhac-tran-may-chu-thu-phi']) }}"></a></div>
                {{--<div class="frame-button denhatbanghoi"><a href="{{ route('front.details.post', ['tong-hop', 'de-nhat-bang-hoi-may-chu-ba-l-ng-huyen']) }}"></a></div>--}}
                <div class="footer">
                    <div class="bottom-logo f-left"><a href="{{ route('front.home') }}"></a></div>
                    <div class="footer-contents f-left">
                        <!-- <p>Bản quyền &copy;2019 Phát hành duy nhất tại: <span class="blue">{{ parse_url(url()->current())['host'] }}</span></p> -->
                        <p>Bản quyền &copy;2019 Phát hành duy nhất tại: <span class="blue">Võ Lâm Trung Nguyên Team</span></p>
                        <p>Địa chỉ: 21 Nguyễn Thái Học, phường Bến Nghé, Quận 1, Thành phố Hồ Chí Minh</p>
                        <p>Điện thoại: <span>0898 002 151</span> Fanpage : <a href="{{ config('site.fb.page_url') }}" target="blank">{{ config('site.fb.page_url') }}</a></p>
                    </div>
                </div>
            </div>
        </section>
    </div>
@include('partials.trackers')
@if(!$user)
    @include('modal.account')
@endif
@section('js')
    <script>
        window.user_id = '{{ \Auth::check() ? \Auth::user()->id : '' }}';
    </script>
    <script type="text/javascript" src="{{ mix('js/landing-2019-11.js') }}"></script>
@show
@include('partials.tracker.fb_chat')
</body>
</html>
