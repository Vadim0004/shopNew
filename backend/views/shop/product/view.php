<?php

use kartik\file\FileInput;
use shop\entities\Shop\Product\Modification;
use shop\entities\Shop\Product\Value;
use shop\helpers\PriceHelper;
use yii\bootstrap\ActiveForm;
use shop\helpers\ProductHelper;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $product shop\entities\Shop\Product\Product */
/* @var $photosForm shop\forms\manage\Shop\Product\PhotosForm */
/* @var $modificationsProvider yii\data\ActiveDataProvider */

$this->title = $product->name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
    <p>
        <?php if ($product->isActiveFeatured()): ?>
            <?= Html::a('Deactivate Fear', ['deactivate-featured', 'id' => $product->id], ['class' => 'btn btn-primary', 'data-method' => 'post']) ?>
        <?php else: ?>
            <?= Html::a('Activate Fear', ['activate-featured', 'id' => $product->id], ['class' => 'btn btn-success', 'data-method' => 'post']) ?>
        <?php endif; ?>
        <?php if ($product->isActive()): ?>
            <?= Html::a('Draft', ['draft', 'id' => $product->id], ['class' => 'btn btn-primary', 'data-method' => 'post']) ?>
        <?php else: ?>
            <?= Html::a('Activate', ['activate', 'id' => $product->id], ['class' => 'btn btn-success', 'data-method' => 'post']) ?>
        <?php endif; ?>
        <?= Html::a('Update', ['update', 'id' => $product->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $product->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#common">Common</a></li>
        <li><a data-toggle="tab" href="#characteristics">Characteristics</a></li>
        <li><a data-toggle="tab" href="#description">Description</a></li>
        <li><a data-toggle="tab" href="#modifications">Modifications</a></li>
        <li><a data-toggle="tab" href="#seo">SEO</a></li>
        <li><a data-toggle="tab" href="#photos">Photos</a></li>
    </ul>

    <div class="tab-content">

        <div id="common" class="tab-pane fade in active">
            <div class="box">
                <div class="box-header with-border">Common</div>
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $product,
                        'attributes' => [
                            'id',
                            [
                                'attribute' => 'is_featured',
                                'value' => ProductHelper::statusLabelFeatured($product->is_featured),
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'status',
                                'value' => ProductHelper::statusLabel($product->status),
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'brand_id',
                                'value' => ArrayHelper::getValue($product, 'brand.name'),
                            ],
                            'code',
                            'name',
                            [
                                'attribute' => 'category_id',
                                'value' => ArrayHelper::getValue($product, 'category.name'),
                            ],
                            [
                                'label' => 'Other categories',
                                'value' => implode(', ', ArrayHelper::getColumn($product->categories, 'name')),
                            ],
                            [
                                'label' => 'Related products',
                                'value' => implode(', ', ArrayHelper::getColumn($product->relatedAssignments, 'related_id')),
                            ],
                            [
                                'label' => 'Tags',
                                'value' => implode(', ', ArrayHelper::getColumn($product->tags, 'name')),
                            ],
                            'quantity',
                            [
                                'attribute' => 'weight',
                                'value' => $product->weight / 1000 . ' kg',
                            ],
                            [
                                'attribute' => 'price_new',
                                'value' => PriceHelper::format($product->price_new),
                            ],
                            [
                                'attribute' => 'price_old',
                                'value' => PriceHelper::format($product->price_old),
                            ],
                        ],
                    ]) ?>
                    <br />
                    <p>
                        <?= Html::a('Change Price', ['price', 'id' => $product->id], ['class' => 'btn btn-primary']) ?>
                        <?php if ($product->canChangeQuantity()): ?>
                            <?= Html::a('Change Quantity', ['quantity', 'id' => $product->id], ['class' => 'btn btn-primary']) ?>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        </div>

        <div id="characteristics" class="tab-pane fade">
            <div class="box box-default">
                <div class="box-header with-border">Characteristics</div>
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $product,
                        'attributes' => array_map(function (Value $value) {
                            return [
                                'label' => $value->characteristic->name,
                                'value' => $value->value,
                            ];
                        }, $product->values),
                    ]) ?>
                </div>
            </div>
        </div>

        <div id="description" class="tab-pane fade">
            <div class="box box-default">
                <div class="box-header with-border">Description</div>
                    <div class="box-body">
                    <?= Yii::$app->formatter->asNtext($product->description) ?>
                </div>
            </div>
        </div>

        <div id="modifications" class="tab-pane fade">
            <div class="box box-default">
                <div class="box-header with-border">Modifications</div>
                <div class="box-body">
                    <p>
                        <?= Html::a('Add Modification', ['shop/modification/create', 'product_id' => $product->id], ['class' => 'btn btn-success']) ?>
                    </p>
                    <?= GridView::widget([
                        'dataProvider' => $modificationsProvider,
                        'columns' => [
                            'code',
                            'name',
                            [
                                'attribute' => 'price',
                                'value' => function (Modification $model) {
                                    return PriceHelper::format($model->price);
                                },
                            ],
                            'quantity',
                            [
                                'class' => ActionColumn::class,
                                'controller' => 'shop/modification',
                                'template' => '{update} {delete}',
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>

        <div id="seo" class="tab-pane fade">
            <div class="box">
                <div class="box-header with-border">SEO</div>
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $product,
                        'attributes' => [
                            [
                                'attribute' => 'meta.title',
                                'value' => $product->meta->title,
                            ],
                            [
                                'attribute' => 'meta.description',
                                'value' => $product->meta->description,
                            ],
                            [
                                'attribute' => 'meta.keywords',
                                'value' => $product->meta->keywords,
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>

        <div id="photos" class="tab-pane fade">
            <div class="box" id="photos">
                <div class="box-header with-border">Photos</div>
                <div class="box-body">
                    <div class="row">
                        <?php foreach ($product->images as $photo): ?>
                            <div class="col-md-2 col-xs-3" style="text-align: center">
                                <div class="btn-group">
                                    <?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span>', ['move-photo-up', 'id' => $product->id, 'photo_id' => $photo->id], [
                                        'class' => 'btn btn-default',
                                        'data-method' => 'post',
                                    ]); ?>
                                    <?= Html::a('<span class="glyphicon glyphicon-remove"></span>', ['delete-photo', 'id' => $product->id, 'photo_id' => $photo->id], [
                                        'class' => 'btn btn-default',
                                        'data-method' => 'post',
                                        'data-confirm' => 'Remove photo?',
                                    ]); ?>
                                    <?= Html::a('<span class="glyphicon glyphicon-arrow-right"></span>', ['move-photo-down', 'id' => $product->id, 'photo_id' => $photo->id], [
                                        'class' => 'btn btn-default',
                                        'data-method' => 'post',
                                    ]); ?>
                                </div>
                                <div>
                                    <?= Html::a(
                                        Html::img($photo->getThumbFileUrl('file', 'thumb')),
                                        $photo->getUploadedFileUrl('file'),
                                        ['class' => 'thumbnail', 'target' => '_blank']
                                    ) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php $form = ActiveForm::begin([
                        'options' => ['enctype'=>'multipart/form-data'],
                    ]); ?>
                    <?= $form->field($photosForm, 'files[]')->label(false)->widget(FileInput::class, [
                        'options' => [
                            'accept' => 'image/*',
                            'multiple' => true,
                        ]
                    ]) ?>
                    <div class="form-group">
                        <?= Html::submitButton('Upload', ['class' => 'btn btn-success']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>

    </div>
</div>