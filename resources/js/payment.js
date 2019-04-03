import Account from './account';

const urlUseCard = '/nap-the';
const btnUseCard = $('#btnUseCard');
const message = $('.payment-message');

$(document).ready(function () {
    btnUseCard.click(function (e) {
        e.preventDefault();
        submitCard();

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

function submitCard() {
    clearMessage();
    if (!window.user_id) {
        showError("Vui lòng đăng nhập trước khi nạp thẻ!");
        setTimeout(function () {
            Account.showLogin();
        }, 1500);
        return;
    }
    var card_type = $('#card_type').val();
    var card_amount = $('#card_amount').val();
    var card_serial = $('#card_serial').val();
    var card_pin = $('#card_pin').val();
    // var valcapt=$('#valcapt').val();
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
    // if(!valcapt){
    //     showError('Vui lòng nhập mã captcha');
    //     popup("pp-fail");
    //     return false;
    // }
    if (card_amount == '') {
        showError('Vui lòng chọn mệnh giá');
        return false;
    }
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
            // reCaptcha();
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
