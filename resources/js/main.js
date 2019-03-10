$(document).ready(function(){
    $('.menu-news div').click(function(){
        var tab_id = $(this).data('tab');
        let link= $(this).data('link');
        $('.menu-news .tab-link').removeClass('active');
        $('.tab-content').removeClass('active');

        $(this).addClass('active');
        $("."+tab_id+"-content").addClass('active');
        $('.menu-news .news-more').attr('href',link)
    });
    $('.my-slider').slick({
        arrows: false,
        fade: false,
        asNavFor: '.slider-nav-thumbnails',
        autoplay:true,
        infinite: true,
        dots:false
    })

    $('.slider-nav-thumbnails').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: '.my-slider',
        focusOnSelect: true,
        autoplay:true,
        nextArrow: '.next-arrow',
		prevArrow: '.pre-arrow',

    });
})
