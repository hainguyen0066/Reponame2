@php
$links = [
    'front.manage.account.info' => "Thông tin tài khoản",
    'front.manage.account.history' => 'Lịch sử giao dịch',
    'front.manage.account.pass' => 'Đổi mật khẩu cấp 1',
    'front.manage.account.pass2' => 'Đổi mật khẩu cấp 2',
]
@endphp
<div class="list-features">
    <div class="title">Danh mục quản lý</div>
    <ul>
        @foreach($links as $route => $title)
        <li class="{{ \Route::currentRouteName() == $route ? 'active' : '' }}">
            <a href="{{  route($route) }}">{{ $title }}</a>
        </li>
        @endforeach
            <li class=""><a href="{{ route('front.static.chuyen_khoan') }}" style="line-height: 30px;">Nạp thẻ</a></li>
    </ul>
</div>
