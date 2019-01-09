<?php

/* @var $this yii\web\View */
/* @var $model \shop\forms\manage\Shop\ConfigurationForm*/

$this->title = 'Create Configuration';
$this->params['breadcrumbs'][] = ['label' => 'Configurations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="tag-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>