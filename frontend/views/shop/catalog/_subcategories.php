<?php
/* @var $category shop\entities\Shop\Category */

use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="panel panel-default">
    <div class="panel-body">
        <?php foreach ($category->children as $child): ?>
            <a href="<?= Html::encode(Url::to(['category', 'id' => $child->id])) ?>"><?= Html::encode($child->name) ?></a> &nbsp;
        <?php endforeach; ?>
    </div>
</div>
