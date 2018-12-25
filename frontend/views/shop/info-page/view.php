<?php

/** @var $infoPage \shop\entities\Shop\InfoPage\InfoPage */

use yii\helpers\Html;

$this->registerMetaTag(['name' =>'description', 'content' => $infoPage->meta->description]);
$this->registerMetaTag(['name' =>'keywords', 'content' => $infoPage->meta->keywords]);

$this->params['breadcrumbs'][] = ['label' => $infoPage->name, 'url' => ['view', 'id' => $infoPage->id]];

?>

<div class="row">
    <div id="infoPage" class="col-sm-12">
        <h1><?= $infoPage->name ?></h1>
        <h2><?= $infoPage->title ?></h2>
        <?= $infoPage->description ?>
        <?= $infoPage->main_content ?>
        <div>
            <?= $infoPage->sliderName->file ? Html::img($infoPage->sliderName->getThumbFileUrl('file', 'thumb')) : null ?>
        </div>
    </div>
</div>