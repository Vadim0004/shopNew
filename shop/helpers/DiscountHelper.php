<?php

namespace shop\helpers;

use yii\helpers\ArrayHelper;

class DiscountHelper
{
    public static function typeList(): array
    {
        return [
            1 => \Yii::$app->formatter->asBoolean(true),
            0 => \Yii::$app->formatter->asBoolean(false),
        ];
    }

    public static function typeName($type): string
    {
        return ArrayHelper::getValue(self::typeList(), $type);
    }
}