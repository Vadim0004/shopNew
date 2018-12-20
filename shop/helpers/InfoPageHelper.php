<?php

namespace shop\helpers;

use shop\entities\Shop\InfoPage\InfoPage;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class InfoPageHelper
{
    public static function statusList(): array
    {
        return [
            InfoPage::STATUS_DRAFT => 'Draft',
            InfoPage::STATUS_ACTIVE => 'Active',
        ];
    }

    public static function statusName($status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status): string
    {
        switch ($status) {
            case InfoPage::STATUS_DRAFT:
                $class = 'label label-default';
                break;
            case InfoPage::STATUS_ACTIVE:
                $class = 'label label-success';
                break;
            default:
                $class = 'label label-default';
        }

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }
}