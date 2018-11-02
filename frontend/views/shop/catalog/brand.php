<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\DataProviderInterface */
/* @var $tag shop\entities\Shop\Tag */

use yii\helpers\Html;

$this->title = $tag->getSeoTitle();

$this->registerMetaTag(['name' =>'description', 'content' => $tag->meta->description]);
$this->registerMetaTag(['name' =>'keywords', 'content' => $tag->meta->keywords]);

$this->params['breadcrumbs'][] = ['label' => 'Catalog', 'url' => ['index']];
$this->params['breadcrumbs'][] = $tag->name;
?>

    <h1><?= Html::encode($brand->name) ?></h1>

    <hr />

<?= $this->render('_list', [
    'dataProvider' => $dataProvider
]) ?>