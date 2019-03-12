<div class="popup-rg-lg dnone">
    <div class="popup-bg-mask">
        <div class="popup-content">
            <div class="popup-menu">
                <div class="btn-login account-login f-left"></div>
                <div class="btn-register account-register f-left"></div>
            </div>
            <div class="popup-tab-content">
                <div class="popup-message"></div>
                <div class="popup-lg">
                    <form method="POST" id="loginForm" action="/login">
                        <input type="text" placeholder="Tên đăng nhập" name="username" class="username input-username">
                        <input type="password" placeholder="Mật khẩu" name="password" class="input-password">
                        <p>Quên mật khẩu? Sử dụng số điên thoại đăng ký gọi đến số <span>0898 002 151</span> để yêu cầu nhận mật khẩu mới.</p>
                        <div class="highlight"></div>
                        <button type="submit" class="btn-submit-login"></button>
                    </form>
                </div>
                <div class="popup-rg">
                    <form method="POST" id="registerForm" action="/register">
                        <input type="text" placeholder="Tên đăng nhập" name="username" class="username input-username">
                        <input type="password" placeholder="Mật khẩu" name="password" class="password input-password">
                        <input type="password" placeholder="Mật khẩu" name="repassword" class="password input-password-confirm">
                        <input type="text" placeholder="Thông tin bảo mật quan trọng" name="phone" class="phone">
                        <div class="highlight"></div>
                        <button type="submit" class="btn-submit-register"></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
