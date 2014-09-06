<? if ($_SERVER['REQUEST_URI'] === "/") { ?>
    <link rel="stylesheet" href="/css/parts/slider.css">
    <script src="/js/libs/jquery.slides.min.js"></script>
    <script src="/js/parts/slider.js"></script>
    <div class="slider">
        <div id="slider__slider" class="slider__slider" style="height: 300px; overflow: hidden;">
            <img src="/img/slider-3.jpg">
            <img src="/img/slider-1.jpg">
            <img src="/img/slider-5.jpg">
            <img src="/img/slider-6.jpg">
            <img src="/img/slider-7.jpg">
        </div>
    </div>
<? } ?>