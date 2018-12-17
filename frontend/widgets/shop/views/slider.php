<?php

use frontend\assets\SliderAsset;

SliderAsset::register($this);
?>

<div id="main-slider" class="carousel slide">
    <ol class="carousel-indicators">
        <li data-target="#main-slider" data-slide-to="0" class="active"></li>
        <li data-target="#main-slider" data-slide-to="1"></li>
    </ol>

    <div class="carousel-inner">
        <div class="item active">
            <img src="<?= "/frontend/web/image/catalog/demo/banners/iPhone6.jpg" ?>" alt=""/>
            <div class="carousel-caption">
                <h3>iPhone 6</h3>
                <p>iPhone 6!</p>
            </div>
        </div>
        <div class="item">
            <img src="<?= "/frontend/web/image/catalog/demo/banners/MacBookAir.jpg" ?>" alt=""/>
            <div class="carousel-caption">
                <h3>MacBookAir</h3>
                <p>MacBookAir!</p>
            </div>
        </div>
    </div>

    <a class="left carousel-control" href="#main-slider" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#main-slider" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<?php $this->registerJs("
    $(document).ready(function() {
        $('#main-slider').carousel({
            interval: 6000
        })
    });
"); ?>
