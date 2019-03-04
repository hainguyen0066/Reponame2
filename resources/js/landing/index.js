require('../bootstrap');
import $ from 'jquery';
import alertify from "alertifyjs";
alertify.set('notifier','position', 'top-right');
import Account from '../account';

const welcomeCodeUrl = './nhan-qua';

$(document).ready(function() {
    // $('.coming-soon').click((e) => {
    //     e.preventDefault();
    //     alertify.notify("Coming Soon! Vui lòng quay lại vào 11h 28-12-2018");
    // });
    $('.gotop').click(function(){
        $('html,body').animate({ scrollTop: 0 }, 'slow');
        return false;
    })
    $('a[href*="#"]:not([href="#"])').click(function() {
        if($(this).parent().parent().parent().attr('class')=='mn-left')
        {
            $('.mn-left li').removeClass('active');
            $(this).parent().addClass('active');
        }
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top
                }, 1500);
                return false;
            }
        }
    });

    $('.ss2-item').click(function (e) {
        let target = $(this).data('target');
        $('#section-02 .ss2-menu li').removeClass('active');
        $('#section-02 .tt-detail').removeClass('active');
        $(this).addClass('active');
        $('#section-02 .' + target).addClass('active');
    })
    $('.btn-pbtn-play-clip, .btn-play-clip').click(function (e) {
        let clip = $(this).data('clip');
        $('.popup-clip iframe').prop('src', clip + '?autoplay=1');
        $('.popup-clip').fadeIn();
    })
    $('.popup-clip .btn-close').on('click', function(e) {
        e.preventDefault();
        $('.popup-clip iframe').prop('src', '');
        $('.popup-clip').fadeOut();
    })

    $('.shareFB').on('click', function (e) {
        e.preventDefault();
        let target = $(this).prop('href');
        target = target ? target : $(this).data('href');
        let quote = $(this).data('quote');
        FB.ui({
            method: 'share',
            href: target,
            quote: quote,
            hashtag: ['#kiemtheweb']
        }, function(response){});
    });
    $('.luudanh').click(function (e) {
        if (!window.t2g.authCheck) {
            return Account.showRegister();
        }
        alertify.notify("Bạn đã `Lưu Danh` thành công, hãy quay lại vào 28-12 để tham gia Close Beta Kiếm Thế Web nhé");
    })
    $('.popup-giftcode .btn-close').click(function(){
        $('.popup-giftcode').css({'display':'none'});
    });
    $('#btn-giftcode').click((e) => {
        if (!window.t2g.authCheck) {
            alertify.notify("Bạn cần Lưu Danh hoặc Đăng Nhập trước khi nhận quà");
            setTimeout(Account.showRegister, 100);
        } else {
            getGiftCode();
        }
    });
})

function getGiftCode() {
    $.post(
        welcomeCodeUrl,
        {},
        (rs) => {
            if (typeof rs.message != 'undefined') {
                alertify.notify(rs.message);
            }
            if (typeof rs.code != 'undefined') {
                $('#welcomeCode').html(rs.code);
                $('.popup-giftcode').fadeIn();
            }
        }
    );
}
