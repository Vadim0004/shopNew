<?php

namespace shop\entities\behaviors;

use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\helpers\Json;
use shop\entities\Shop\InfoPage\InfoPageStatus;

class InfoPageBehavior extends Behavior
{
    public $attribute = 'statuses';
    public $jsonAttribute = 'sys_statuses_json';

    public function events(): array
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'onAfterFind',
            ActiveRecord::EVENT_BEFORE_INSERT => 'onBeforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'onBeforeSave',
        ];
    }

    public function onAfterFind(Event $event): void
    {
        $model = $event->sender;
        $infoPage = Json::decode($model->getAttribute($this->jsonAttribute));
        $model->{$this->attribute} = array_map(function ($row) {
            return new InfoPageStatus(
                $row['value'],
                $row['created_at']
            );
        }, $infoPage);
    }


    public function onBeforeSave(Event $event): void
    {
        $model = $event->sender;
        $model->setAttribute($this->jsonAttribute, Json::encode(array_map(function (InfoPageStatus $status) {
            return [
                'value' => $status->value,
                'created_at' => $status->created_at,
            ];
        }, $model->{$this->attribute})));
    }
}