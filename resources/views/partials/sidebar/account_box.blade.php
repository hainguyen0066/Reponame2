<div class="charge">
    <a href="{{ route('front.payment.index') }}" class="sprite btn btn-charge" title="Nạp tiền"></a>
    <a href="{{ route("front.gift_code") }}" class="sprite btn btn-gift-code" title="Nhập Code"></a>
    <div class="clearfix"></div>
</div>
@if(!Auth::user())
<div class="register-login">
    <div class="sprite register-btn account-register"></div>
    <div class="sprite login-btn account-login"></div>
</div>
@else
<div class="info-user">
    <div class="info-title"></div>
    <div class="info-content">
        <p>Tài khoản: <span>{{ str_limit($user->name, 20) }}</span></p>
        <p>Mật khẩu 2: {!! $user->displayPass2() !!}</p>
        <p>Địa chỉ IP: <span>{{ request()->getClientIp() }}</span></p>
        <p>Điện thoại: {!! $user->displayPhone() !!}</p>
    </div>
    <div class="two-btn">
        <div class="btn-manage"><a href="{{ route('front.manage.account.info') }}"></a></div>
        <div class="btn-exit"><a href="{{ route('logout') }}"></a></div>
    </div>
</div>
@endif
