<?php

namespace shop\entities\behaviors;

use shop\entities\Meta;
use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\helpers\Json;

class MetaBehavior extends Behavior
{
    public $attribute = 'meta';
    public $jsonAttribute = 'meta_json';

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
        $meta = Json::decode($model->getAttribute($this->jsonAttribute));
        $model->{$this->attribute} = new Meta(
            $meta['title'],
            $meta['description'],
            $meta['keywords']);
    }

    public function onBeforeSave(Event $event): void
    {
        $model = $event->sender;
        $json = Json::encode([
            'title' => $model->{$this->attribute}->title,
            'description' => $model->{$this->attribute}->description,
            'keywords' => $model->{$this->attribute}->keywords,
        ]);
        $model->__set($this->jsonAttribute, $json);
    }
}