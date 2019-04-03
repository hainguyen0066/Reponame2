<div class="details-content">
    <div class="header-details-content">
        <p class="c-white">{{ $page->title }}</p>
        {{ Breadcrumbs::render('charge-detail', $page->title) }}
    </div>
    <div class="main-details-content">
        <div class="manage-charge">
            <div class="head-title">CÁC HÌNH THỨC NẠP THẺ</div>
            <div class="list-btn-charge">
                <ul>
                    <li class="{{ Route::currentRouteName() == 'front.static.nap_the_cao' ? 'active' : '' }}">
                        <a href="{{ route('front.static.nap_the_cao') }}">Nạp thẻ cào</a>
                    </li>
                    <li class="{{ Route::currentRouteName() == 'front.static.vi_momo' ? 'active' : '' }}">
                        <a href="{{ route('front.static.vi_momo') }}">Ví MOMO</a>
                    </li>
                    <li class="{{ Route::currentRouteName() == 'front.static.chuyen_khoan' ? 'active' : '' }}">
                        <a href="{{ route('front.static.chuyen_khoan') }}">Chuyển khoản ngân hàng</a>
                    </li>
                </ul>
            </div>
        </div>
        {!! $page->body !!}
        @if(view()->exists('pages.static.group.' . $page->view))
            @include('pages.static.group.' . $page->view)
        @endif
    </div>
</div>
