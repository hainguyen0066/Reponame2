<div class="charge">
    <a href="{{ route('front.static.nap_the_cao') }}">
        <span></span>
    </a>
</div>
@if(!Auth::user())
<div class="register-login">
    <div class="register-btn account-register"></div>
    <div class="login-btn account-login"></div>
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
