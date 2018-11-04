<?php

/** @var $featuredProd \shop\entities\Shop\Product\Product[] */
/** @var $product \shop\entities\Shop\Product\Product */

use yii\helpers\Url;
use yii\helpers\Html;

?>

<h3>Featured</h3>
<div class="row">
    <?php foreach ($featuredProd as $product): ?>
        <div class="product-layout col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="product-thumb transition">
                <div class="image">
                    <a href="<?= Html::encode(Url::to(['shop/catalog/product', 'id' => $product->id]))?>">
                        <img src="<?= Html::encode($product->mainPhoto->getThumbFileUrl('file', 'catalog_list')) ?>" alt="" class="img-responsive"/>
                    </a>
                </div>
                <div class="caption">
                    <h4>
                        <a href="<?= Html::encode(Url::to(['shop/catalog/product', 'id' => $product->id]))?>">
                            <?= Html::encode($product->name) ?>
                        </a>
                    </h4>
                    <p><?= Html::encode($product->description) ?></p>
                    <p class="price"><?= Html::encode($product->price_new) ?></p>
                </div>
                <div class="button-group">
                    <button type="button" onclick="cart.add('43');"><i class="fa fa-shopping-cart"></i> <span
                                class="hidden-xs hidden-sm hidden-md">Add to Cart</span></button>
                    <button type="button" data-toggle="tooltip" title="Add to Wish List"
                            onclick="wishlist.add('43');"><i class="fa fa-heart"></i></button>
                    <button type="button" data-toggle="tooltip" title="Compare this Product"
                            onclick="compare.add('43');"><i class="fa fa-exchange"></i></button>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>