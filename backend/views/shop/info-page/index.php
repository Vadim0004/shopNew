<?php

use shop\entities\Shop\InfoPage\InfoPage;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;
use shop\helpers\InfoPageHelper;
use shop\helpers\InfoPageStatusHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\Shop\InfoPageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Info Page';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <p>
        <?= Html::a('Create Info Page', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'attribute' => 'name',
                        'value' => function (InfoPage $model) {
                            return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                    ],
                    'title',
                    'slug',
                    [
                        'attribute' => 'status',
                        'filter' => $searchModel->statusList(),
                        'value' => function (InfoPage $model) {
                            return InfoPageHelper::statusLabel($model->status);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'sys_id',
                        'filter' => $searchModel->sysIdList(),
                        'value' => function (InfoPage $model) {
                            return InfoPageStatusHelper::statusLabel($model->sys_id);
                        },
                        'format' => 'raw',
                    ],
                    ['class' => ActionColumn::class],
                ],
            ]); ?>
        </div>
    </div>
</div>