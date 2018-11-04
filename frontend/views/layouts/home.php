<?php

/* @var $this \yii\web\View */
/* @var $content string */

\frontend\assets\OwlCarouselAsset::register($this);
use frontend\widgets\shop\FeaturedProductsWidget;
?>

<?php $this->beginContent('@frontend/views/layouts/main.php') ?>
<div class="row">
    <div id="content" class="col-sm-12">
        <div id="slideshow0" class="owl-carousel" style="opacity: 1;">
            <div class="item">
                <a href="index.php?route=product/product&amp;path=57&amp;product_id=49"><img
                        src="<?= "/backend/web/upload/cache/catalog/demo/banners/iPhone6.jpg" ?>"
                        alt="iPhone 6" class="img-responsive"/></a>
            </div>
            <div class="item">
                <img src="<?= "/backend/web/upload/cache/catalog/demo/banners/MacBookAir.jpg" ?>"
                     alt="MacBookAir" class="img-responsive"/>
            </div>
        </div>
        <?= FeaturedProductsWidget::widget([
                'limit' => Yii::$app->params['limitFeaturedProducts'],
        ]) ?>
        <div id="carousel0" class="owl-carousel">
            <div class="item text-center">
                <img src="<?= "/backend/web/upload/cache/catalog/demo/manufacturer/nfl.png" ?>" alt="NFL"
                     class="img-responsive"/>
            </div>
            <div class="item text-center">
                <img src="<?= "/backend/web/upload/cache/catalog/demo/manufacturer/redbull.png" ?>"
                     alt="RedBull" class="img-responsive"/>
            </div>
            <div class="item text-center">
                <img src="<?= "/backend/web/upload/cache/catalog/demo/manufacturer/sony.png" ?>" alt="Sony"
                     class="img-responsive"/>
            </div>
            <div class="item text-center">
                <img src="<?= "/backend/web/upload/cache/catalog/demo/manufacturer/cocacola.png" ?>"
                     alt="Coca Cola" class="img-responsive"/>
            </div>
            <div class="item text-center">
                <img src="<?= "/backend/web/upload/cache/catalog/demo/manufacturer/burgerking.png" ?>"
                     alt="Burger King" class="img-responsive"/>
            </div>
            <div class="item text-center">
                <img src="<?= "/backend/web/upload/cache/catalog/demo/manufacturer/canon.png" ?>" alt="Canon"
                     class="img-responsive"/>
            </div>
            <div class="item text-center">
                <img src="<?= "/backend/web/upload/cache/catalog/demo/manufacturer/harley.png" ?>"
                     alt="Harley Davidson" class="img-responsive"/>
            </div>
            <div class="item text-center">
                <img src="<?= "/backend/web/upload/cache/catalog/demo/manufacturer/dell.png" ?>" alt="Dell"
                     class="img-responsive"/>
            </div>
            <div class="item text-center">
                <img src="<?= "/backend/web/upload/cache/catalog/demo/manufacturer/disney.png" ?>"
                     alt="Disney" class="img-responsive"/>
            </div>
            <div class="item text-center">
                <img src="<?= "/backend/web/upload/cache/catalog/demo/manufacturer/starbucks.png" ?>"
                     alt="Starbucks" class="img-responsive"/>
            </div>
            <div class="item text-center">
                <img src="<?= "/backend/web/upload/cache/catalog/demo/manufacturer/nintendo.png" ?>"
                     alt="Nintendo" class="img-responsive"/>
            </div>
        </div>
        <?= $content ?>
    </div>
</div>

<?php $this->registerJs('
$(\'#slideshow0\').owlCarousel({
    items: 1,
    loop: true,
    autoplay:true,
    autoplayTimeout:3000,
    autoplayHoverPause:true,
    nav: true,
    navText: [\'<i class="fa fa-chevron-left fa-5x"></i>\', \'<i class="fa fa-chevron-right fa-5x"></i>\'],
    dots: true
});') ?>

<?php $this->registerJs('
$(\'#carousel0\').owlCarousel({
    items: 6,
    loop: true,
    autoplay:true,
    autoplayTimeout:3000,
    autoplayHoverPause:true,
    nav: true,
    navText: [\'<i class="fa fa-chevron-left fa-5x"></i>\', \'<i class="fa fa-chevron-right fa-5x"></i>\'],
    dots: true
});') ?>

<?php $this->endContent() ?>