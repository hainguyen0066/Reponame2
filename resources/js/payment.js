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
    jconfirm({
        type: 'orange',
        title: 'Lưu Ý',
        content: '<div>Vui lòng kiểm tra lại mệnh giá thẻ để tránh mất thẻ.</div><div>Mệnh giá hiện tại: <span class="c-red">' + amount + '</span></div>',
        useBootstrap: false,
        theme: 'material',
        boxWidth: '400px',
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
