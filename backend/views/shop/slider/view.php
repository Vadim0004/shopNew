<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $slider shop\entities\Shop\Slider */
/* @var $photosForm \shop\forms\manage\Shop\Product\PhotosForm */

$this->title = $slider->name;
$this->params['breadcrumbs'][] = ['label' => 'Slider', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $slider->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $slider->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="box">
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $slider,
                'attributes' => [
                    'id',
                    'name',
                    'comment',
                ],
            ]) ?>
        </div>
    </div>

    <div class="box" id="photos">
        <div class="box-header with-border">Photos</div>
        <div class="box-body">
            <div class="row">
                    <div class="col-md-2 col-xs-3" style="text-align: center">
                        <div>
                            <?= Html::a(
                                Html::img($slider->getThumbFileUrl('file', 'thumb')),
                                $slider->getUploadedFileUrl('file'),
                                ['class' => 'thumbnail', 'target' => '_blank']
                            ) ?>
                        </div>
                    </div>
                </div>

                <?php $form = ActiveForm::begin([
                    'options' => ['enctype' => 'multipart/form-data'],
                ]); ?>

                <?= $form->field($photosForm, 'files')->label(false)->widget(FileInput::class, [
                    'options' => [
                        'accept' => 'image/*',
                    ],
                    'pluginOptions'=>[
                        'maxFileCount' => 1,
                        'allowedFileExtensions'=>['jpg','jpeg','gif','png']
                    ],
                ]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Upload', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>