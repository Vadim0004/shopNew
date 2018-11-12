<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model \shop\forms\manage\Shop\DiscountForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="characteristic-form">
    <?php $form = ActiveForm::begin() ?>

    <div class="box box-default">
        <div class="box-body">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'percent')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'from_date')->widget(DatePicker::class, [
                'name' => 'dp_2',
                'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                'convertFormat' => true,
                'value' => $model->from_date,
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-MM-dd'
                ]
            ]); ?>

            <?= $form->field($model, 'to_date')->widget(DatePicker::class, [
                'name' => 'dp_2',
                'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                'convertFormat' => true,
                'value' => $model->to_date,
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-MM-dd'
                ]
            ]); ?>
            <?= $form->field($model, 'active')->checkbox() ?>
            <?= $form->field($model, 'sort')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php $form = ActiveForm::end() ?>
</div>