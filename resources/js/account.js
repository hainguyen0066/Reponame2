import $ from 'jquery';
const MSG_TYPE_SUCCESS = 'success';
const MSG_TYPE_ERROR = 'error';
const activeClass = 'active';
let loginUrl = './login';
let registerUrl = './register';

const Account = {
    show: () => {
        Account.clearMessage();
        $('.pp-dk-dn').fadeIn().addClass(activeClass);
    },
    close: () =>  {
        $('.pp-dk-dn').fadeOut().removeClass(activeClass);
    },
    showRegister: () => {
        $('.ct-dk-dn, .mn-dk-dn .menu-btn').removeClass(activeClass);
        $('.ct-dk-dn.ct-dk, .mn-dk-dn .menu-btn.btn-dk').addClass(activeClass);
        Account.show();
    },
    showLogin: () => {
        $('.ct-dk-dn, .mn-dk-dn .menu-btn').removeClass(activeClass);
        $('.ct-dk-dn.ct-dn, .mn-dk-dn .menu-btn.btn-dn').addClass(activeClass);
        Account.show();
    },
    showMessage: (msg, type) => {
        let el = $('.pp-dk-dn .msg-dk-dn');
        el.html("<span class='" + type + "'>" + msg + "</span>");
    },
    clearMessage: () => {
        $('.pp-dk-dn .msg-dk-dn').html('');
    },
    login: () => {
        let $tabLogin = $('.pp-dk-dn .ct-dk-dn.ct-dn');
        let username = $tabLogin.find('.input-username').val();
        let password = $tabLogin.find('.input-password').val();
        $.ajax({
            url: loginUrl,
            method: 'POST',
            data: {
                name: username,
                password: password
            },
            success: (rs) => {
                Account.showMessage("Đăng nhập thành công", MSG_TYPE_SUCCESS);
                setTimeout(() => {
                    window.location.reload();
                }, 1500)
            },
            error: (rs) => {
                let msg = 'Có lỗi xảy ra, vui lòng thử lại sau';
                if (typeof rs.responseJSON.errors != 'undefined') {
                    for (let i in rs.responseJSON.errors) {
                        msg = rs.responseJSON.errors[i];
                        break;
                    }
                }
                Account.showMessage(msg, MSG_TYPE_ERROR);
            },
            dataType: 'json'
        });
    },
    register: () => {
        let $tabRegister = $('.pp-dk-dn .ct-dk-dn.ct-dk');
        let username = $tabRegister.find('.input-username').val();
        let password = $tabRegister.find('.input-password').val();
        let passwordConfirm = $tabRegister.find('.input-password-confirm').val();
        let email = $tabRegister.find('.input-email').val();
        $.ajax({
            url: registerUrl,
            method: 'POST',
            data: {
                name: username,
                password: password,
                password_confirmation: passwordConfirm,
                email: email,
            },
            success: (rs) => {
                Account.showMessage("Đăng ký tài khoản thành công", MSG_TYPE_SUCCESS);
                setTimeout(() => {
                    window.location.reload();
                }, 2000)
            },
            error: (rs) => {
                let msg = 'Có lỗi xảy ra, vui lòng thử lại sau';
                if (typeof rs.responseJSON.errors != 'undefined') {
                    for (let i in rs.responseJSON.errors) {
                        msg = rs.responseJSON.errors[i];
                        break;
                    }
                }
                Account.showMessage(msg, MSG_TYPE_ERROR);
            },
            dataType: 'json'
        });
    },
}

$(document).ready(() => {
    $('.pp-dk-dn .btn-close').click(() => {
        Account.close();
    });
    $('.mn-dk-dn .menu-btn.btn-dk, .ct-dk-dn .link-dk, .dk-nt .dk-nt-dk').click(() => {
        Account.showRegister();
    });
    $('.mn-dk-dn .menu-btn.btn-dn, .ct-dk-dn .link-dn').click(() => {
        Account.showLogin();
    });

    $('#registerForm').submit((e) => {
        e.preventDefault();
        Account.register();
    });

    $('#loginForm').submit((e) => {
        e.preventDefault();
        Account.login();
    });
});

export default Account;
