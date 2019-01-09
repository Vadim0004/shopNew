<?php

use shop\entities\Shop\Configuration;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\Shop\ConfigurationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Configuration';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <p>
        <?= Html::a('Create Configuration', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    'id',
                    [
                        'attribute' => 'configuration_title',
                        'value' => function (Configuration $model) {
                            return Html::a(Html::encode($model->configuration_title), ['view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                    ],
                    'configuration_value',
                    ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {update}'],
                ],
            ]); ?>
        </div>
    </div>
</div>