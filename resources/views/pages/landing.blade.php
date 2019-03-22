<!DOCTYPE html>
<html>
<head>
    @component('meta')
    @slot('title')
        @section('title'){{ $title ?? config('site.seo.title') }}@show
    @endslot
    @slot('meta_description')
        {{ $meta_description ?? config('site.seo.meta_description') }}
    @endslot
    @slot('meta_keyword')
        {{ $meta_keyword ?? config('site.seo.meta_keyword') }}
    @endslot
    @endcomponent
    <link rel="stylesheet" href="{{ mix('css/landing.css') }}">
    <link rel="stylesheet" href="{{ mix('css/account.css') }}">
</head>
<body>
    <div class="wrapper">
        <div class="section-01">
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
                    @if(!Auth::user())
                        <div class="register-btn account-register"></div>
                        <div class="download"> <a href="{{ route('front.page.download')}}"></a></div>
                        <div class="login-btn account-login"></div>
                    @else
                        <div class="charge"><a href="{{ route('front.static.nap_the_cao') }}"></a></div>
                        <div class="download"><a href="{{ route('front.page.download')}}"></a></div>
                        <div class="logout"><a href="{{ route('logout')}}"></a></div>
                    @endif
                </div>
            </div>
        </div>
        <div class="section-02"></div>
        <div class="section-03">
            <div class="container">
                <div class="download"> <a href="{{ route('front.page.download')}}"></a></div>
            </div>
        </div>
        <div class="section-04">
            <div class="container">
                <div class="download"> <a href="{{ route('front.page.download')}}"></a></div>
            </div>
        </div>
        <div class="section-05">
            <div class="container">
                <div class="volamtranhba"><a href="{{ route('front.details.post', ['tong-hop','su-kien-ba-chu-vo-lam'])}}"></a></div>
                <div class="quanhunghoitu"><a href="{{ route('front.details.post', ['tong-hop','chuoi-su-kien-close-beta-20-03'])}}"></a></div>
                <div class="anhhungthiep"><a href="https://www.facebook.com/volamtrungnguyen2019/videos/283765432499493" target="_blank"></a></div>
                <div class="denhatbanghoi"><a href="{{ route('front.details.post', ['tong-hop','de-nhat-bang-hoi'])}}"></a></div>
            </div>
        </div>
        <div class="footer">
            <div class="container">
                <div class="bottom-logo f-left"><a href="{{ route('front.home') }}"></a></div>
                <div class="footer-contents f-left">
                    <p>Bản quyền &copy;2019 Phát hành duy nhất tại: <span class="blue">vltrungnguyen.com</span></p>
                    <p>Địa chỉ: 21 Nguyễn Thái Học, phường Bến Nghé, Quận 1, Thành phố Hồ Chí Minh</p>
                    <p>Điện thoại: <span>0898 002 151</span> Fanpage : <a href="{{ config('site.fb.page_url') }}" target="blank">{{ config('site.fb.page_url') }}</a></p>
                </div>
            </div>
        </div>
    </div>
@include('partials.trackers')
@if(!$user)
    @include('modal.account')
@endif
@section('js')
    @include('partials.scripts')
@show
@include('partials.tracker.fb_chat')
</body>
</html>
