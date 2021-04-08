<div class="header">
    <video id="intro"
        poster="{{ staticUrl('images/BG--Tet-2021.jpg') }}"
        preload="auto" loop muted autoplay playsinline>
        <source src="{{ staticUrl('images/trang_chu_tet_2021.mp4') }}" type="video/mp4">
    </video>
    <div class="header-content">
        <div class="container">
            <div class="top-menu">
                <ul>
                    <li><a href="{{ route('front.home') }}" class="{{ (\Request::route()->getName() == 'front.home' || \Request::route()->getName() == 'front.landing') ? 'active' : '' }}">Trang Chủ</a></li>
                    <li><a href="{{ route('front.category', ['su-kien']) }}" class="{{ (\Request::route()->categorySlug == 'su-kien') ? 'active' : '' }}">Sự Kiện</a></li>
                    <li><a href="{{ route('front.category', ['huong-dan']) }}" class="{{ (\Request::route()->categorySlug == 'huong-dan') ? 'active' : '' }}">Hướng Dẫn</a></li>
                    <li class="logo"><a href="{{ route('front.home') }}" title="Trang chủ">{{ config('app.name') }}</a></li>
                    <li><a href="{{ route('front.static.nap_the_cao') }}" class="{{ (\Request::route()->getName() == 'front.static.nap_the_cao') ? 'active' : '' }}">Nạp Thẻ</a></li>
                    <li><a href="{{ config('site.fb.page_url') }}" target="_blank">Fanpage</a></li>
                    <li><a href="{{ config('site.fb.group_url') }}" target="_blank">Group</a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
