<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \shop\forms\manage\Shop\ConfigurationForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tag-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-default">
        <div class="box-body">
            <?= $form->field($model, 'configuration_title')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'configuration_key')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'configuration_value')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'configuration_description')->textarea(['rows' => 10]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
