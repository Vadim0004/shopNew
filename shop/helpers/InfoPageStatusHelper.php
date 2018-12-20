<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 20.12.2018
 * Time: 16:33
 */

namespace shop\helpers;

use shop\entities\Shop\InfoPage\InfoPageStatus;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class InfoPageStatusHelper
{
    public static function statusList(): array
    {
        return [
            InfoPageStatus::PAGE_OTHER => 'Other',
            InfoPageStatus::PAGE_ABOUT => 'About',
            InfoPageStatus::PAGE_CONTACT => 'Contact',
            InfoPageStatus::PAGE_MAIN => 'Main',
        ];
    }

    public static function statusName($status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status): string
    {
        switch ($status) {
            case InfoPageStatus::PAGE_OTHER:
                $class = 'label label-default';
                break;
            case InfoPageStatus::PAGE_ABOUT:
                $class = 'label label-success';
                break;
            case InfoPageStatus::PAGE_CONTACT:
                $class = 'label label-info';
                break;
            case InfoPageStatus::PAGE_MAIN:
                $class = 'label label-danger';
                break;
            default:
                $class = 'label label-default';
        }

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }
}