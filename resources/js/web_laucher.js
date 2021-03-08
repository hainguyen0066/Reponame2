require('./jquery-3.5.1.min');
require('./bootstrap');
require('./slick.min');

$(document).ready(() => {
    $('.slider').slick({
        dots: true,
        autoplay:true,
        infinite: true,
        speed: 400,
        autoplaySpeed: 5000,
        arrows:false,
        button:false,
        slidesToShow: 1,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 640,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });
});