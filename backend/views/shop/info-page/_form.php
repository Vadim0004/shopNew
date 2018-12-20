<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

/* @var $this yii\web\View */
/* @var $model \shop\forms\manage\Shop\InfoPage\InfoPageForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="brand-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-default">
        <div class="box-header with-border">Common</div>
        <div class="box-body">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'sort')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'slider_name')->dropDownList($model->getSliderNames()) ?>
            <?= $form->field($model, 'additional_data')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="box box-default">
        <div class="box-header with-border">Add html text</div>
        <div class="box-body">
            <?= $form->field($model, 'main_content')->widget(CKEditor::class, [
                'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
                    'preset' => 'standard',
                    'clientOptions' => [
                        'config.allowedContent' => true,
                        'allowedContent' => true,
                    ],
                ]),
            ]) ?>
            <?= $form->field($model, 'description')->widget(CKEditor::class, [
                'editorOptions' => ElFinder::ckeditorOptions('elfinder', [
                    'preset' => 'standard',
                    'clientOptions' => [
                        'config.allowedContent' => true,
                        'allowedContent' => true,
                    ],
                ]),
            ]) ?>
        </div>
    </div>

    <div class="box box-default">
        <div class="box-header with-border">SEO</div>
        <div class="box-body">
            <?= $form->field($model->meta, 'title')->textInput() ?>
            <?= $form->field($model->meta, 'description')->textarea(['rows' => 2]) ?>
            <?= $form->field($model->meta, 'keywords')->textInput() ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
