<?php

/* @var $this yii\web\View */
/* @var $configuration shop\entities\Shop\Configuration */
/* @var $model \shop\forms\manage\Shop\ConfigurationForm */

$this->title = 'Update Configuration: ' . $configuration->configuration_title;
$this->params['breadcrumbs'][] = ['label' => 'Configurations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $configuration->configuration_title, 'url' => ['view', 'id' => $configuration->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tag-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>