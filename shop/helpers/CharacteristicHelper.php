<?php

namespace shop\helpers;

use shop\entities\Shop\Characteristic;
use yii\helpers\ArrayHelper;

class CharacteristicHelper
{
    public static function typeList(): array
    {
        return [
            Characteristic::TYPE_STRING => 'String',
            Characteristic::TYPE_INTEGER => 'Integer number',
            Characteristic::TYPE_FLOAT => 'Float number',
        ];
    }

    public static function typeName($type): string
    {
        return ArrayHelper::getValue(self::typeList(), $type);
    }

    public static function getLineBreak(array $arrayVariants)
    {
        $getArrayWithKeys = (explode(', ', implode(PHP_EOL, $arrayVariants)));
        $result = implode(PHP_EOL, $getArrayWithKeys);
        return $result;
    }

    public static function getArrayVariants(array $arrayVariants): array
    {
        $implode = implode(', ', $arrayVariants);
        $result = explode(', ', $implode);
        $array = [];
        foreach ($result as $key => $value)
        {
            $array[$value] = $value;
        }
        return $array;
    }
}