import $ from "jquery";
require('jquery-confirm');

$(document).ready(function(){
    $('.menu-news div').click(function(){
        let tab_id = $(this).data('tab');
        let link= $(this).data('link');
        $('.menu-news .tab-link').removeClass('active');
        $('.news .tab-content').removeClass('active');

        $(this).addClass('active');
        $("."+tab_id+"-content").addClass('active');
        $('.menu-news .news-more').attr('href',link)
    });

    $('.newbies .newbies-header .newbies-title').click(function(){
        let tab_id = $(this).data('tab');
        let link= $(this).data('link');
        $('.newbies .newbies-header .newbies-title').removeClass('active');
        $('.newbies .tab-content').removeClass('active');

        $(this).addClass('active');
        $(".newbies ."+tab_id+"-content").addClass('active');
        $('.newbies .newbies-header .newbies-more a').attr('href',link);
    });

    $('.activity-tabs a').click(function(){
        let tab = $(this).data('tab');
        $('.activity-tabs a').removeClass('active');
        $(this).addClass('active');
        $(".activity-tab-container").removeClass('active');
        $(".activity-tab-container." + tab).addClass('active');
    });

    $('.my-slider').slick({
        arrows: false,
        fade: false,
        asNavFor: '.slider-nav-thumbnails',
        autoplay:true,
        infinite: true,
        dots:false
    });

    $('.slider-nav-thumbnails').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: '.my-slider',
        focusOnSelect: true,
        autoplay:true,
        nextArrow: '.next-arrow',
		prevArrow: '.pre-arrow',

    });
    $(".popup-banner").click(function(){
        $(".popup-banner").css("display", "none");
    });

    $('.main-details-content .post-body img').each(function (index, element) {
        let $image = $(element);
        if ($image.width() < 50) {
            return;
        }
        if ($image.parent('a').length) {
            return;
        }
        let lighboxClicker = $('<a href="javascript:;" style="cursor:zoom-in;"></a>');
        lighboxClicker.insertBefore($(element));
        $(element).appendTo(lighboxClicker);
        lighboxClicker.click(function (e) {
            e.preventDefault();
            jconfirm({
                title: '',
                content: '<div style="text-align:center"><img style="max-width: 800px" src="'+$(this).find('img').prop('src')+'"/></div>',
                useBootstrap: false,
                theme: 'material',
                backgroundDismiss: true,
            });
        });
    });

    $('#intro').addClass('active');
});
