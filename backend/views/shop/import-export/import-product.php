<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model shop\forms\manage\Shop\Product\ImportForm */

$this->title = 'Import Product';
?>

<div class="user-index">
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
    <div class="box">

        <div class="box box-default">
            <div class="box-header with-border">Csv files</div>
            <div class="box-body">
                <?= $form->field($model, 'filesCsv')->fileInput() ?>
            </div>
        </div>

    </div>

    <div class="form-group">
        <?= Html::submitButton('Upload', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
