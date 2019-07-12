import Account from './account';
require('jquery-confirm');

const urlUseCard = '/nap-the';
const btnUseCard = $('#btnUseCard');
const message = $('.payment-message');

$(document).ready(function () {
    btnUseCard.click(function (e) {
        e.preventDefault();
        onCardSubmission();
        return false;
    })
})

function clearMessage() {
    message.text('');
}
function showSuccess(msg) {
    message.removeClass('error').addClass('success');
    message.text(msg);
}

function showError(error) {
    message.removeClass('success').addClass('error');
    message.text(error);
}

function validateCard() {
    var card_type = $('#card_type').val();
    var card_amount = $('#card_amount').val();
    var card_serial = $('#card_serial').val();
    var card_pin = $('#card_pin').val();
    if (card_type == '') {
        showError('Vui lòng chọn loại thẻ cào');
        return false;
    }
    if (card_serial == '') {
        showError('Vui lòng nhập Số Seri của thẻ');
        return false;
    }
    if (!card_pin) {
        showError('Vui lòng nhập Mã Thẻ');
        return false;
    }
    if (card_amount == '') {
        showError('Vui lòng chọn mệnh giá');
        return false;
    }

    return true;
}

function showPrompt() {
    let amount = $('#card_amount option:selected').text();
    let card_serial = $('#card_serial').val();
    let card_pin = $('#card_pin').val();
    let card_type = $('#card_type option:selected').text();
    jconfirm({
        type: 'orange',
        title: 'Lưu Ý',
        content: '' +
            '<div>Vui lòng kiểm tra lại thông tin thẻ <em class="c-red">(đặc biệt là mệnh giá)</em>.</div>' +
            '<div>Loại thẻ: <span>' + card_type + '</span></div>' +
            '<div>Số Seri: <span>' + card_serial + '</span></div>' +
            '<div>Mã thẻ: <span>' + card_pin + '</span></div>' +
            '<div>Mệnh giá: <span class="c-red">' + amount + '</span></div>' +
            '<hr/><div class="c-red">Nếu chọn sai mệnh giá thẻ sẽ mất thẻ và không nhận được Tiền Đồng.</div>',
        useBootstrap: false,
        theme: 'material',
        boxWidth: '430px',
        buttons: {
            ok: {
                btnClass: "btn-green",
                action: function () {
                    submitCard();
                }
            },
            cancel: {
                btnClass: "btn-red",
                action: function () {}
            }
        }
    });
}

function submitCard() {
    btnUseCard.attr('disabled', 'disabled');
    $.ajax({
        dataType: "json",
        type: 'POST',
        url: urlUseCard,
        data: $('#formUseCard').serialize(),
        cache: false,
        success: function (data) {
            if (data.relogin) {
                setTimeout(function() {
                    Account.showLogin();
                }, 1500);
            }
            if (data.msg) {
                showSuccess(data.msg);
            } else {
                showError(data.error);
            }
            btnUseCard.removeAttr("disabled");
        },
        error: function () {
            btnUseCard.removeAttr("disabled");
        }
    });
}

function onCardSubmission() {
    clearMessage();
    if (!window.user_id) {
        showError("Vui lòng đăng nhập trước khi nạp thẻ!");
        setTimeout(function () {
            Account.showLogin();
        }, 1500);
        return;
    }
    if (!validateCard()) {
        return;
    }
    showPrompt();
}
