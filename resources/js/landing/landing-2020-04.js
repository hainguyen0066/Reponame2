require('../bootstrap');
import $ from "jquery";
import Account from '../account';
import AOS from 'aos';

$(document).ready(function () {
    $('body, section').addClass('ready');
    $(window).scroll(function (e) {
        if ($(this).scrollTop() > 30) {
            $('.icon-scroll').addClass('scrolling');
            $('.anchor').addClass('run');
        } else {
            $('.anchor').removeClass('run');
        }
        if ($(this).scrollTop() > 3600) {
            $('.icon-scroll').hide(300);
        } else {
            $('.icon-scroll').show(300);
        }
    });
    $('#goTop').click(function (e) {
        $("html, body").animate({ scrollTop: 0 }, 500);
    });

    const SECTION1_HEIGHT = 1000;
    const SECTION2_HEIGHT = 1000;
    const SECTION3_HEIGHT = 1000;
    const SECTION4_HEIGHT = 1000;
    const SECTION5_HEIGHT = 800;
    function resize() {
        let wwidth = $(window).width();
        let ratio = wwidth / 1920;
        $('.section-01').height(SECTION1_HEIGHT * ratio);
        $('.section-02').height(SECTION2_HEIGHT * ratio);
        $('.section-03').height(SECTION3_HEIGHT * ratio);
        $('.section-04').height(SECTION4_HEIGHT * ratio);
        $('.section-05').height(SECTION5_HEIGHT * ratio);
        // $('body').height(BODY_HEIGHT * ratio);
        $('.menu').css({
            width: 495 * ratio,
            height: 51 * ratio,
        });
        $('.section-01 .text').css({
            width: 342 * ratio,
            height: 109 * ratio,
        });
        $('.menu ul').css({
            'padding-left': 95 * ratio,
        });

        $('.menu li').css({
            width: 100 * ratio,
        });

        $('.menu li:eq(0)').css({
            width: 115 * ratio,
        });

        $('.menu li a').css({
            'font-size': 15 * ratio,
            'line-height': `${30 * ratio }px`
        });

        $('.logo a').css({
            width: 192 * ratio,
            height: 192 * ratio
        });
        $('.download').css({
            width: 270 * ratio,
            height: 132 * ratio
        });
        $('.register-btn').css({
            width: 215 * ratio,
            height: 135 * ratio
        });

        $('.section-02 .char').css({
            width: 533 * ratio,
            height: 756 * ratio
        });

        $('.section-03 .event-1').css({
            width: 287 * ratio,
            height: 203 * ratio
        });
        $('.section-03 .event-2').css({
            width: 319 * ratio,
            height: 203 * ratio
        });
        $('.section-03 .event-3').css({
            width: 287 * ratio,
            height: 203 * ratio
        });

        $('.section-03 .char').css({
            width: 557 * ratio,
            height: 373 * ratio
        });

        $('.section-04 .btn-try').css({
            width: 270 * ratio,
            height: 90 * ratio
        });

        $('.btn-join').css({
            width: 270 * ratio,
            height: 86 * ratio,
            'background-position': `0 -${ 6 * ratio}px`
        });

        $('.section-05 .frame-button').css({
            width: 285 * ratio,
            height: 359 * ratio
        });

        $('.section-05 .frame-button a span').css({
            width: 117 * ratio,
            height: 40 * ratio
        });

        $('footer *').css({
            'font-size': 16 * ratio,
            'line-height': `${25 * ratio}px`
        });

        $('.anchor').css({
            width: 220 * ratio,
            height: 241 * ratio
        });

        $('.icon-scroll').css({
            width: 62 * ratio,
            height: 86 * ratio
        });
        $('#goTop').css({
            width: 59 * ratio,
            height: 99 * ratio
        });

        $('.btn-giftcode').css({
            width: 500 * ratio,
            height: 400 * ratio
        });
        $('.btn-giftcode span').css({
            "font-size": (24 * ratio) + 'px'
        });

        if (wwidth < 800) {
            $('#popupGiftCode .popup-banner-container').css({
                width: 480 * ratio,
                height: 480 * ratio
            });
            $('#popupGiftCode .popup-banner-container a').css({
                "font-size": (18 * ratio) + 'px'
            });
            $('#popupGiftCode .popup-close').css({
                width: 30 * ratio,
                height: 30 * ratio
            });
        }

        $('.loader').hide();
        $('.btn-giftcode').show(500);
    }
    resize();
    $(window).resize(function () {
        resize();
    });
    setTimeout(() => $('.loader').hide(), 1000);

    AOS.init();

    $('.logged').click(() => {
        $('#popupGiftCode').show();
    });

    $(".popup-banner").click(function(){
        $(".popup-banner").css("display", "none");
    });
});
