<?php

namespace shop\helpers;

use shop\entities\Shop\Product\Product;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class ProductHelper
{
    public static function statusList(): array
    {
        return [
            Product::STATUS_DRAFT => 'Draft',
            Product::STATUS_ACTIVE => 'Active',
        ];
    }

    public static function statusName($status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status): string
    {
        switch ($status) {
            case Product::STATUS_DRAFT:
                $class = 'label label-default';
                break;
            case Product::STATUS_ACTIVE:
                $class = 'label label-success';
                break;
            default:
                $class = 'label label-default';
        }

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }

    public static function statusListFeatured(): array
    {
        return [
            Product::STATUS_FEATURED_ON => 'Featured',
            Product::STATUS_FEATURED_OFF => 'No featured',
        ];
    }

    public static function statusLabelFeatured($is_featured): string
    {
        switch ($is_featured) {
            case Product::STATUS_FEATURED_OFF:
                $class = 'label label-default';
                break;
            case Product::STATUS_FEATURED_ON:
                $class = 'label label-success';
                break;
            default:
                $class = 'label label-default';
        }

        return Html::tag('span', ArrayHelper::getValue(self::statusListFeatured(), $is_featured), [
            'class' => $class,
        ]);
    }
}