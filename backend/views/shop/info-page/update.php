<?php

/* @var $this yii\web\View */
/* @var $infoPage \shop\entities\Shop\InfoPage\InfoPage */
/* @var $model \shop\forms\manage\Shop\InfoPage\InfoPageForm */

$this->title = 'Update Brand: ' . $infoPage->name;
$this->params['breadcrumbs'][] = ['label' => 'Info Page', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $infoPage->name, 'url' => ['view', 'id' => $infoPage->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="brand-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>