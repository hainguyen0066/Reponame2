import $ from 'jquery';

const MSG_TYPE_SUCCESS = 'success';
const MSG_TYPE_ERROR = 'error';
const activeClass = 'active';
let urlLogin = '/login';
let urlRegister = '/register';
const menuLinkLoginSelector = '.popup-menu .btn-login';
const menuLinkRegisterSelector = '.popup-menu .btn-register';
const messageContainerSelector = '.popup-message';
const popupContainerSelector = '.popup-rg-lg';
const tabLoginSelector = '.popup-lg';
const tabRegisterSelector = '.popup-rg';

let FLAG_IS_SUBMITTING_DATA = false;

const Account = {
    container: null,
    menuLinkLogin: null,
    menuLinkRegister: null,
    messageContainer: null,
    tabLogin: null,
    tabRegister: null,
    setContainer: (containerSelector) => {
        Account.container = $(containerSelector);
        Account.menuLinkLogin = Account.container.find(menuLinkLoginSelector);
        Account.menuLinkRegister = Account.container.find(menuLinkRegisterSelector);
        Account.messageContainer = Account.container.find(messageContainerSelector);
        Account.tabLogin = Account.container.find(tabLoginSelector);
        Account.tabRegister = Account.container.find(tabRegisterSelector);
    },
    show: () => {
        Account.clearMessage();
        Account.container.fadeIn().addClass(activeClass);

    },
    close: () =>  {
        Account.container.fadeOut().removeClass(activeClass);
    },
    showRegister: () => {
        Account.tabRegister.addClass(activeClass);
        Account.tabLogin.removeClass(activeClass);
        Account.show();
        Account.menuLinkLogin.removeClass(activeClass);
        Account.menuLinkRegister.addClass(activeClass);
    },
    showLogin: () => {
        Account.tabLogin.addClass(activeClass);
        Account.tabRegister.removeClass(activeClass);
        Account.show();
        Account.menuLinkRegister.removeClass(activeClass);
        Account.menuLinkLogin.addClass(activeClass);
    },
    showMessage: (msg, type) => {
        Account.messageContainer.html("<span class='" + type + "'>" + msg + "</span>");
    },
    clearMessage: () => {
        console.log(Account.messageContainer);
        Account.messageContainer.html('');
    },
    login: () => {
        Account.clearMessage();
        let username = Account.tabLogin.find('input.username').val();
        let password = Account.tabLogin.find('.input-password').val();
        $.ajax({
            url: urlLogin,
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
        if (FLAG_IS_SUBMITTING_DATA) {
            return;
        }
        Account.clearMessage();
        FLAG_IS_SUBMITTING_DATA = true;
        let username = Account.tabRegister.find('.input-username').val();
        let password = Account.tabRegister.find('.input-password').val();
        let passwordConfirm = Account.tabRegister.find('.input-password-confirm').val();
        let phone = Account.tabRegister.find('.phone').val();
        $.ajax({
            url: urlRegister,
            method: 'POST',
            data: {
                name: username,
                password: password,
                password_confirmation: passwordConfirm,
                phone: phone,
            },
            success: (rs) => {
                Account.showMessage("Đăng ký tài khoản thành công", MSG_TYPE_SUCCESS);
                setTimeout(() => {
                    if (rs.intended) {
                        window.location.href = rs.intended;
                    } else {
                        window.location.reload();
                    }
                }, 2000);

                FLAG_IS_SUBMITTING_DATA = false;
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
                FLAG_IS_SUBMITTING_DATA = false;
            },
            dataType: 'json'
        });
    },
};

$(document).ready(() => {
    const $popupContainer = $(popupContainerSelector);
    Account.setContainer($popupContainer);
    $popupContainer.find('.account-close, .popup-bg-mask').click(function(e) {
        const closeClasses = ['account-close', 'popup-bg-mask'];
        if (closeClasses.indexOf($(e.target)[0].className) != -1) {
            Account.close();
        }
    });

    $('.account-register').click(() => {
        Account.showRegister();
    });

    $('.account-login').click(() => {
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
