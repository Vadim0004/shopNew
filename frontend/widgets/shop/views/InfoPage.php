<?php

/** @var $infoPage \shop\entities\Shop\InfoPage\InfoPage[] */

use yii\helpers\Url;
use yii\helpers\Html;

?>

<div class="row">
    <div id="infoPage" class="col-sm-12">
        <?php foreach ($infoPage as $page): ?>
            <a href="<?= Html::encode(Url::to(['shop/info-page/view', 'id' => $page->id])) ?>"><?= Html::encode($page->name) ?>
                <br></a>
        <?php endforeach; ?>
    </div>
</div>