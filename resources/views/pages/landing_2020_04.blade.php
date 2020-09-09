<!DOCTYPE html>
<html lang="vi" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
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
    <link rel="stylesheet" href="{{ staticUrl('css/landing-2020-04.css', true) }}">
    <link rel="stylesheet" href="{{ staticUrl('css/account.css', true) }}">
    @include('t2g_common::schemas.home')
</head>
<body>
    <div class="loader"></div>
    @include('partials.btn_giftcode')
    <div class="wrapper">
        <section class="section-01">
            @include('partials.intro')
            <div class="logo"><a href="{{ route('front.home')}}"></a></div>
            <div class="menu">
                <ul>
                    <li><a href="{{ route('front.home')}}">Trang chủ</a></li>
                    <li><a href="{{ config('site.fb.page_url') }}" target="_blank">Fanpage</a></li>
                    <li><a href="{{ config('site.fb.group_url')}}" target="_blank">Group</a></li>
                </ul>
            </div>
            <a class="register-btn {{ $user ? 'logged' : 'account-register' }}" title="Đăng ký"></a>
            <a class="download" href="{{ route('front.page.download')}}" title="Tải game"></a>
            <a href="javascript:" class="icon-scroll" title="Scroll xuống để xem tiếp">Scroll xuống để xem tiếp</a>
            <div class="text"></div>
        </section>
        <section class="section-02">
            <div class="char animate__animated animate__pulse animate__infinite"></div>
            <a href="{{ $user ? route('front.page.download') : 'javascript:;' }}"
               data-aos="zoom-out-down"
               class="btn-join {{ $user ? 'account-register' : '' }}"></a>
        </section>
        <section class="section-03">
            <div class="download"> <a class="" href="{{ route('front.page.download')}}"></a></div>
            <div class="event-1" data-aos="zoom-out-down" data-aos-delay=""></div>
            <div class="event-2" data-aos="zoom-out-down" data-aos-delay="300"></div>
            <div class="event-3" data-aos="zoom-out-down" data-aos-delay="600"></div>
            <div class="char animate__animated animate__headShake animate__infinite"></div>
            <a href="{{ $user ? route('front.page.download') : 'javascript:;' }}"
               data-aos="zoom-out-down"
               class="btn-join {{ $user ? 'account-register' : '' }}"></a>
        </section>
        <section class="section-04">
            <a class="btn-try" href="{{ route('front.page.download')}}" data-aos="zoom-out-down"></a>
        </section>
        <section class="section-05">
            <div class="frame-button volamtranhba" data-aos="zoom-in-right">
                <a href="{{ route('front.details.post', ['su-kien','vo-lam-tranh-ba'])}}">
                    <span class="center">&nbsp;</span>
                </a>
            </div>
            <div class="frame-button quanhunghoitu" data-aos="zoom-in-right">
                <a href="{{ route('front.details.post', ['su-kien','chuoi-su-kien-close-beta-server-phuong-tuong']) }}">
                    <span class="center">&nbsp;</span>
                </a>
            </div>
            <div class="frame-button anhhungthiep" data-aos="zoom-in-left">
                <a href="{{ route('front.details.post', ['su-kien','anh-hung-thiep-khai-mo-server-phuong-tuong']) }}">
                    <span class="center">&nbsp;</span>
                </a>
            </div>
            <div class="frame-button tuyetdinhsuquan" data-aos="zoom-in-left">
                <a href="{{ route('front.details.post', ['tong-hop','trieu-tap-bang-hoi']) }}">
                    <span class="center">&nbsp;</span>
                </a>
            </div>
            <a href="javascript:" id="goTop" class="">Go top</a>
        </section>
        <footer>
            <p>Bản quyền &copy;2019 Phát hành duy nhất tại: <span>jxtrungnguyen2005.com</span></p>
            <p>Địa chỉ: 21 Nguyễn Thái Học, phường Bến Nghé, Quận 1, Thành phố Hồ Chí Minh</p>
            <p>Điện thoại: <span>0898 002 151</span> Fanpage : <a href="{{ config('site.fb.page_url') }}" target="blank" title="Fanpage">{{ config('site.fb.page_url') }}</a></p>
        </footer>
    </div>
{{--    <div class="anchor">--}}
{{--        <ul>--}}
{{--            <li>--}}
{{--                <a href="{{ route('front.page.download') }}" target="_blank">--}}
{{--                    tải game--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li>--}}
{{--                @if(empty($user))--}}
{{--                <a href="javascript:" class="account-register">--}}
{{--                    đăng ký--}}
{{--                </a>--}}
{{--                @else--}}
{{--                    <a href="{{ route('logout') }}">--}}
{{--                        thoát--}}
{{--                    </a>--}}
{{--                @endif--}}
{{--            </li>--}}
{{--            <li>--}}
{{--                <a href="{{ route('front.payment.index') }}" target="_blank">--}}
{{--                    nạp thẻ--}}
{{--                </a>--}}
{{--            </li>--}}

{{--        </ul>--}}
{{--    </div>--}}
@include('partials.trackers')
@if(!$user)
    @include('modal.account')
@endif
@include('modal.giftcode')
@section('js')
    <script>
        window.user_id = '{{ \Auth::check() ? \Auth::user()->id : '' }}';
    </script>
    <script type="text/javascript" src="{{ staticUrl('js/landing-2020-04.js', true) }}"></script>
@show
@include('partials.tracker.fb_chat')
</body>
</html>
