const urlUseCard = '/payment';
const  btnUseCard = $('#btnUseCard');
$(document).ready(function () {
    btnUseCard.click(function (e) {
        e.preventDefault();
        submitCard();
    })
})

function showSuccess(msg) {
    $('.payment-message').removeClass('error').addClass('success').html(msg);
}

function showError(error) {
    $('.payment-message').removeClass('success').addClass('error').html(error);
}

function submitCard() {
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
        data: $('#form_charge').serialize(),
        cache: false,
        success: function (data) {
            // reCaptcha();
            if (data.state == 1) {
                showSuccess(data.msg);
            }
            else {
                showError(data.msg);
            }
            btnUseCard.removeAttr("disabled");
        }
    });
}
