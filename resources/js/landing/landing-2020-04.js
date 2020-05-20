require('../bootstrap');
import Account from '../account';
import loadIntro from './../t2g';

$(document).ready(function () {
    $('body, section').addClass('ready');
    $(window).scroll(function (e) {
        if ($(this).scrollTop() > 30) {
            $('.icon-scroll').addClass('scrolling');
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

    loadIntro('intro');
});
