<?php

/* @var $this yii\web\View */
/* @var $model \shop\forms\manage\Shop\DiscountForm */
/* @var $discount \shop\entities\Shop\Discount */

$this->title = 'Update Discount';
$this->params['breadcrumbs'][] = ['label' => 'Discount', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="discount-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
