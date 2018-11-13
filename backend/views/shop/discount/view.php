<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use shop\helpers\DiscountHelper;

/* @var $this yii\web\View */
/* @var $discount \shop\entities\Shop\Discount */

$this->title = $discount->name;
$this->params['breadcrumbs'][] = ['label' => 'Discounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $discount->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $discount->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="box">
        <div class="box-header with-border">Common</div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $discount,
                'attributes' => [
                    'id',
                    'percent',
                    'name',
                    'from_date',
                    'to_date',
                    [
                        'attribute' => 'active',
                        'value' => DiscountHelper::typeName($discount->active),
                    ],
                    'sort',
                ],
            ]) ?>
        </div>
    </div>

</div>
