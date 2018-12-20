<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use shop\helpers\InfoPageHelper;
use shop\helpers\InfoPageStatusHelper;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $infoPage \shop\entities\Shop\InfoPage\InfoPage */

$this->title = $infoPage->name;
$this->params['breadcrumbs'][] = ['label' => 'Info page', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-view">

    <p>

        <?php if ($infoPage->isActive()): ?>
            <?= Html::a('Draft', ['draft', 'id' => $infoPage->id], ['class' => 'btn btn-primary', 'data-method' => 'post']) ?>
        <?php else: ?>
            <?= Html::a('Activate', ['activate', 'id' => $infoPage->id], ['class' => 'btn btn-success', 'data-method' => 'post']) ?>
        <?php endif; ?>

        <?= Html::a('Update', ['update', 'id' => $infoPage->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $infoPage->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>

        <?= Html::a('Change status', ['edit-status', 'id' => $infoPage->id], ['class' => 'btn modalButton', 'data-method' => 'post']) ?>

    </p>

    <div class="box">
        <div class="box-header with-border">Common</div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $infoPage,
                'attributes' => [
                    'id',
                    [
                        'attribute' => 'status',
                        'value' => InfoPageHelper::statusLabel($infoPage->status),
                        'format' => 'raw',
                    ],
                    'name',
                    'slug',
                    [
                        'attribute' => 'sys_id',
                        'value' => InfoPageStatusHelper::statusLabel($infoPage->sys_id),
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'statuses.created_at',
                        'value' => Yii::$app->formatter->asTime(ArrayHelper::getValue($infoPage->statuses[0], 'created_at'), 'h:i:s'),
                    ],
                ],
            ]) ?>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">Main content</div>
        <div class="box-body">
            <?= Yii::$app->formatter->asNtext($infoPage->main_content) ?>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">Description</div>
        <div class="box-body">
            <?= Yii::$app->formatter->asNtext($infoPage->description) ?>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">Additional information</div>
        <div class="box-body">
            <?= Yii::$app->formatter->asNtext($infoPage->additional_data) ?>
        </div>
    </div>

    <div class="box">
        <div class="box-header with-border">SEO</div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $infoPage,
                'attributes' => [
                    'meta.title',
                    'meta.description',
                    'meta.keywords',
                ],
            ]) ?>
        </div>
    </div>

    <?php

    Modal::begin([
        'header' => 'Change status Info Page',
        'id' => 'modal',
        'size' => 'modal-lg',
    ]);

    echo "<div id='modalContent'></div>";
    Modal::end();

    ?>

</div>
