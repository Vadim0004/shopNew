<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use shop\helpers\InfoPageStatusHelper;

/* @var $this yii\web\View */
/* @var $model \shop\forms\manage\Shop\InfoPage\InfoPageStatusForm */
/* @var $infoPage \shop\entities\Shop\InfoPage\InfoPage */
?>

<?php $form = ActiveForm::begin(); ?>

    <div class="box-body">
        <?= $form->field($model, 'sysId')->dropDownList(InfoPageStatusHelper::statusList()) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

