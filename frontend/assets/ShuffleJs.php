<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class ShuffleJs extends AssetBundle
{
    public $sourcePath = '@bower/shuffleJs/dist';
    public $js = [
        'shuffle.js',
    ];
}