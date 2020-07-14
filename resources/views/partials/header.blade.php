<div class="header">
    <video id="intro"
        poster="{{ asset('images/landing-2020-04/bg-f1-l.jpg?v=1') }}"
        preload="auto" loop muted autoplay playsinline>
        <source src="{{ asset('images/trang_chu.mp4') }}" type="video/mp4">
    </video>
    <div class="header-content">
        <div class="container">
            <div id="slogan"></div>
            <div class="top-menu">
                <ul>
                    <li><a href="{{ route('front.home') }}" class="active">Trang Chủ</a></li>
                    <li><a href="{{ route('front.category', ['su-kien']) }}">Sự Kiện</a></li>
                    <li><a href="{{ route('front.category', ['huong-dan']) }}">Hướng Dẫn</a></li>
                    <li class="logo"><a href="{{ route('front.home') }}" title="Trang chủ">{{ config('app.name') }}</a></li>
                    <li><a href="{{ route('front.static.nap_the_cao') }}">Nạp Thẻ</a></li>
                    <li><a href="{{ config('site.fb.page_url') }}" target="_blank">Fanpage</a></li>
                    <li><a href="{{ config('site.fb.group_url') }}" target="_blank">Group</a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
