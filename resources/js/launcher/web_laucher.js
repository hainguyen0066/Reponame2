var sliders = document.querySelectorAll(".image-slider");
var sliderDots = document.querySelectorAll(".slide-dot");
var i = 0;

function hideSlider (k) {
    for (var i = 0; i < sliders.length; i++) {
        sliders[i].classList.remove("active");
        sliderDots[i].classList.remove('active');
    }
    sliders[k].classList.add("active");
    sliderDots[k].classList.add('active');
}

try {
    hideSlider(1);
    setInterval(function (){
        i++;
        if (i === 4){
            i = 0;
        }
        hideSlider(i)
    },3000);
}
catch(err) {
}

