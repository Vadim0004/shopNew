<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use shop\entities\Shop\Configuration;

/* @var $this yii\web\View */
/* @var $configuration shop\entities\Shop\Configuration */

$this->title = $configuration->configuration_value;
$this->params['breadcrumbs'][] = ['label' => 'Configuration', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <p>
        <?= Html::a('Create', ['create', 'id' => $configuration->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Update', ['update', 'id' => $configuration->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $configuration,
                'attributes' => [
                    'id',
                    'configuration_title',
                    'configuration_key',
                    'configuration_value',
                    'configuration_description',
                    [
                        'attribute' => 'created_at',
                        'value' => function (Configuration $model) {
                            return Yii::$app->formatter->asTime($model->created_at, 'h:i:s');
                        },
                    ],
                ],
            ]) ?>
        </div>
    </div>
</div>