<?php

use shop\entities\Shop\Brand;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\Shop\BrandSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Brands';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <p>
        <?= Html::a('Create Brand', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
        <div class="box-body">

            <?= Html::button('Multiple Delete', [
                'id' => 'MyButton',
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this items?',
                    'method' => 'post',
                ],
            ]) ?>

            <?= GridView::widget([
                'id'=> 'brands_display',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'class' => 'yii\grid\CheckboxColumn', 'checkboxOptions' => function (Brand $model) {
                            return ['value' => $model->id];
                    },
                    ],
                    'id',
                    [
                        'attribute' => 'name',
                        'value' => function (Brand $model) {
                            return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                    ],
                    'slug',
                    ['class' => ActionColumn::class],
                ],
            ]); ?>
        </div>
    </div>
</div>

<script type="text/javascript">

    <?php
    $this->registerJs(' 
            $(document).ready(function(){
            $(\'#MyButton\').click(function(){
                var BrandId = $(\'#brands_display\').yiiGridView(\'getSelectedRows\');
                  $.ajax({
                    type: \'POST\',
                    url : \'multiple-delete\',
                    data : {row_id: BrandId},
                    success : function() {
                      $(this).closest(\'tr\').remove();
                    }
                });
            });
            });', \yii\web\View::POS_READY);
    ?>

</script>