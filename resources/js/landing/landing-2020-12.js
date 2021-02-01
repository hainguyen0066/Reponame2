require('../bootstrap');
import $ from "jquery";
import Account from '../account';
import AOS from 'aos';

$(document).ready(function () {

    $('body, section').addClass('ready');

    const section01 = $('#section-01');
    const menu01    = $('#menu01');

    const section02 = $('#section-02');
    const menu02    = $('#menu02');

    const section03 = $('#section-03');
    const menu03    = $('#menu03');

    const section05 = $('#section-05');
    const menu04    = $('#menu04');

    const section06 = $('#section-06');
    const menu05    = $('#menu05');

    menu01.addClass('active');

    $(window).scroll(function (e) {
        const scrollTop = $(this).scrollTop() + 1;
        if(scrollTop < section01.offset().top || scrollTop  < section01.height() ) {
            menu01.addClass('active');
        } else {
            menu01.removeClass('active');
        }

        if(scrollTop  >= section02.offset().top && scrollTop <=  section03.offset().top) {
            menu02.addClass('active');
        } else {
            menu02.removeClass('active');
        }

        if(scrollTop >= section03.offset().top && scrollTop <=  section05.offset().top) {
            menu03.addClass('active');
        } else {
            menu03.removeClass('active');
        }

        if(scrollTop >= section05.offset().top && scrollTop <=  section06.offset().top) {
            menu04.addClass('active');
        } else {
            menu04.removeClass('active');
        }

        if(scrollTop >= section06.offset().top) {
            menu05.addClass('active');
        } else {
            menu05.removeClass('active');
        }

    });

    const SECTION1_HEIGHT = 1192;
    const SECTION2_HEIGHT = 496;
    const SECTION3_HEIGHT = 440;
    const SECTION4_HEIGHT = 460;
    const SECTION5_HEIGHT = 900;
    const SECTION6_HEIGHT = 1000;
    const SECTION7_HEIGHT = 202;
    const section1 = $('#section-01');
    const section2 = $('#section-02');
    const section3 = $('#section-03');
    const section4 = $('#section-04');
    const section5 = $('#section-05');
    const section6 = $('#section-06');
    const section7 = $('#section-07');

    function resize() {
        let wwidth = $(window).width();
        let ratio = wwidth / 1920;
        section1.height(SECTION1_HEIGHT * ratio);
        section2.height(SECTION2_HEIGHT * ratio);
        section3.height(SECTION3_HEIGHT * ratio);
        section4.height(SECTION4_HEIGHT * ratio);
        section5.height(SECTION5_HEIGHT * ratio);
        section6.height(SECTION6_HEIGHT * ratio);
        section7.height(SECTION7_HEIGHT * ratio);

        $('.container').css({
            width: 1170 * ratio
        });
        $('.join-now').css({
            height: 100 * ratio,
        });
        $('.join-now .character').css({
            height: 642 * ratio,
            width: 495 * ratio,
        });
        $('.join-now .join-text').css({
            'font-size': 31 * ratio + 'px',
        });

        // section 1
        section1.find('.menu').css({
            width: 495 * ratio,
            height: 51 * ratio,
        });
        section1.find('.menu ul li').css({
            width: 115 * ratio,
        });
        section1.find('.menu ul li a').css({
            'font-size': (14 * ratio) + 'px',
        });

        section1.find('.icon-top').css({
            width: 29 * ratio,
            height: 219 * ratio,
        });
        section1.find('.icon-bottom').css({
            width: 34 * ratio,
            height: 219 * ratio,
        });
        section1.find('.menu-left-content').css({
            width: 105 * ratio,
        });
        section1.find('.trang-chu-number').css({
            width: 40 * ratio,
            height: 40 * ratio,
            'line-height': (40 * ratio) + 'px',
            'margin-top': 8 / ratio,
            'margin-bottom': 8 / ratio,
            border: (3 * ratio) + 'px solid #d58f02'
        });
        section1.find('.number-content').css({
            'margin-bottom': 20 * ratio,
            'font-size': 16 * ratio + 'px'
        });
        section1.find('.menu-left-content .separator').css({
            height: 10 * ratio,
        });
        section1.find('.logo a').css({
            width: 192 * ratio,
            height: 170 * ratio,
        });
        section1.find('.text').css({
            width: 632 * ratio,
            height: 273 * ratio,
        });
        section1.find('.logo-congthanhchien').css({
            width: 141 * ratio,
            height: 121 * ratio,
        });

        section1.find('.text-server-moi').css({
            width: 629 * ratio,
            height: 119 * ratio,
        });

        section1.find('.down-and-giftcode').css({
            width: 669 * ratio,
            height: 140 * ratio,
        });

        section1.find('a.download').css({
            width: 246 * ratio,
            height: 118 * ratio,
        });

        section1.find('a.register').css({
            width: 317 * ratio,
            height: 120 * ratio,
        });

        section1.find('.update-special').css({
            'max-width': (1162 * ratio) + 'px',
            height: 282 * ratio,
        });

        section1.find('.menu').css({
            width: 494 * ratio,
            height: 51 * ratio,
        });

        // section 2
        section2.find('.event-title').css({
            height: 92 * ratio,
            'margin-top': (30 * ratio) + 'px',
            'margin-bottom': (65 * ratio) + 'px',
        });
        section2.find('.event-content a').css({
            height: 238 * ratio,
        });
        section2.find('.btn-join').css({
            width: 270 * ratio,
            height: 86 * ratio,
        });

        // section 3
        section3.find('.update-title').css({
            height: 92 * ratio,
            'margin-bottom': (45 * ratio) + 'px',
            'margin-top': (30 * ratio) + 'px',
        });
        section3.find('.update-content').css({
            width: 915 * ratio,
        });
        section3.find('.update-content a').css({
            height: 210 * ratio,
        });

        // section 4
        section4.css({
            'padding-bottom': (40 * ratio) + 'px',
        });
        section4.find('.info-server .info-title').css({
            width: 331 * ratio,
            height: 38 * ratio,
            'margin-top': 20 * ratio,
        });
        section4.find('.info-server .info-content').css({
            'padding-top': (25 * ratio) + 'px',
            'padding-left': (60 * ratio) + 'px',
        });
        section4.find('.info-server .info-content ul').css({
            width: 4350 * ratio,
        });
        section4.find('.info-server .info-content ul:first-child').css({
            'margin-right': 30 * ratio,
        });
        section4.find('.info-server .info-content ul li').css({
            'font-size': (18 * ratio) + 'px',
        });
        section4.find('.info-server .info-content ul li .icon').css({
            width: 16 * ratio,
            height: 22 * ratio,
            'margin-right': 10 * ratio,
        });

        // section 5
        section5.find('.dinhhuong-phattrien').css({
            width: 1165 * ratio,
            height: 811 * ratio,
        });

        // section 6
        section6.find('.hotro-tanthu-title').css({
            height: 92 * ratio,
            'margin-top': (30 * ratio) + 'px',
            'margin-bottom': (30 * ratio) + 'px',
        });
        section6.find('.hotro-tanthu-content').css({
            'padding-right': (80 * ratio) + 'px',
        });
        section6.find('.gift-left').css({
            height: 631 * ratio,
        });
        section6.find('.gift-lv10').css({
            'font-size': (24 * ratio) + 'px',
        });
        section6.find('.gift-left > ul').css({
            'margin-left': (62 * ratio) + 'px',
            'margin-top': (190 * ratio) + 'px'
        });
        section6.find('.gift-left > ul li p').css({
            'font-size': (22 * ratio) + 'px',
        });
        section6.find('.gift-left > ul li .icon').css({
            width: 16 * ratio,
            height: 22 * ratio,
            'margin-right': (10 * ratio) + 'px'
        });
        section6.find('.gift-right').css({
            height: 600 * ratio,
        });

        $('.join-btn').css({
            width: 228 * ratio,
            height: 62 * ratio,
            'margin-left': 20 * ratio,
        });

        section6.find('.gift-right .gift-lv').css({
            width: 489 * ratio,
            height: 94 * ratio,
            'margin-top': 16 * ratio
        });

        section6.find('.gift-right .gift-lv .gift-lv-title').css({
            'font-size': 16 * ratio
        });

        section6.find('.gift-right .gift-lv .gift-lv-content').css({
            'padding-left': 40 * ratio,
            'padding-top': 8 * ratio
        });
        section6.find('.gift-right .gift-lv .gift-lv-content > div:first-child').css({
            'margin-right': 30 * ratio
        });
        section6.find('.gift-right .gift-lv .gift-lv-content p').css({
            'font-size': 18 * ratio
        });
        section6.find('.gift-right .gift-lv .gift-lv-content .icon').css({
            width: 16 * ratio,
            height: 22 * ratio,
            'margin-right': 10 * ratio
        });
        section6.find('.gift-right .gift-lv .gift-lv-content .icon').css({
            width: 16 * ratio,
            height: 22 * ratio,
            'margin-right': 10 * ratio
        });
        section6.find('.hotro-tanthu-content .gift-left > ul li + li').css({
            'margin-top': 30 * ratio
        });
        section6.find('.volam-2005').css({
            width: 950 * ratio,
            height: 110 * ratio,
        });
        section6.find('.volam-2005 .btn-volam2005').css({
            width: 270 * ratio,
            height: 91 * ratio,
        });

        // section 7
        section7.find('.character').css({
            width: 340 * ratio,
            height: 300 * ratio,
        });
        section7.find('.info-support').css({
            'margin-left': 400 * ratio,
            'padding-top': 30 * ratio,
        });
        section7.find('.info-support .text span').css({
            'font-size': 36 * ratio,
        });
        section7.find('.info-support .phone').css({
            'margin-top': 20 * ratio,
            'margin-bottom': 20 * ratio,
        });
        section7.find('.info-support .phone span').css({
            'font-size': 36 * ratio,
        });
        section7.find('.info-support .phone span:first-child').css({
            'margin-right': 40 * ratio,
            'padding-right': 40 * ratio,
        });
        section7.find('.question').css({
            'font-size': 22 * ratio
        });

        section7.find('.question a').css({
            width: 169 * ratio,
            height: 30 * ratio,
            'margin-left': 20 * ratio,
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

    AOS.init();
    setTimeout(() => $('.loader').hide(), 1000);

    $('.logged').click(() => {
        $('#popupGiftCode').show();
    });

    $(".popup-banner").click(function(){
        $(".popup-banner").css("display", "none");
    });
});
