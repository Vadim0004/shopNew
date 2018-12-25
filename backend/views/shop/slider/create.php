<?php

/* @var $this yii\web\View */
/* @var $model shop\forms\manage\Shop\SliderForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

$this->title = 'Create Slider';
$this->params['breadcrumbs'][] = ['label' => 'Slider', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="brand-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-default">
        <div class="box-header with-border">Common</div>
        <div class="box-body">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="box box-default">
        <div class="box-header with-border">Photos</div>
        <div class="box-body">
            <?= $form->field($model, 'files')->widget(FileInput::class, [
                'options' => [
                    'accept' => 'image/*',
                ],
                'pluginOptions'=>[
                    'maxFileCount' => 1,
                    'allowedFileExtensions'=>['jpg','jpeg','gif','png']
                ],
            ]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>