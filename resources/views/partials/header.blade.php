<div class="header">
    <div class="container">
        <div class="top-logo"><a href="{{ route('front.home') }}" title="Trang chủ"></a></div>
        <div class="top-menu">
            <ul>
                <li><a href="{{ route('front.home') }}" class="active">Trang Chủ</a></li>
                <li><a href="{{ route('front.category', ['su-kien']) }}">Sự Kiện</a></li>
                <li><a href="{{ route('front.category', ['huong-dan']) }}">Hướng Dẫn</a></li>
                <li><a href="{{ route('front.static.nap_the_cao') }}">Nạp Thẻ</a></li>
                <li><a href="{{ config('site.fb.page_url') }}" target="_blank">Fanpage</a></li>
                <li><a href="{{ config('site.fb.group_url') }}" target="_blank">Group</a></li>
            </ul>
        </div>
    </div>
</div>
