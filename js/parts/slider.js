$(function(){
    $("#slider__slider").slidesjs({
        width: 960,
        height: 300,
        navigation: { active: false },
        pagination: { active: false },
        play: {
            active: false,
            interval: 5000,
            auto: true,
            swap: false
        },
        effect: {
            slide: {
                speed: 1000
            }
        }
    });
});