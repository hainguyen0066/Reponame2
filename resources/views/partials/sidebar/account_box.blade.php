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
        <p>Mật khẩu 2:
            @if(empty($user->pass2))
                <span>Chưa cập nhật</span>
            @else
                <span style="color: green">Đã cập nhật</span>
            @endif
        </p>
        <p>Địa chỉ IP: <span>{{ request()->getClientIp() }}</span></p>
        <p>Điện thoại: <span>{{ $user->phone ? str_pad($user->phone, 7, '*') : '' }}</span></p>
    </div>
    <div class="two-btn">
        <div class="btn-manage"><a href="{{ route('front.account.index') }}"></a></div>
        <div class="btn-exit"><a href="{{ route('logout') }}"></a></div>
    </div>
</div>
@endif
