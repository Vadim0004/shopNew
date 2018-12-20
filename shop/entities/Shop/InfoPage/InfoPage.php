<?php

namespace shop\entities\Shop\InfoPage;

use shop\entities\Shop\Slider;
use yii\db\ActiveRecord;
use shop\entities\Meta;
use shop\entities\behaviors\MetaBehavior;
use shop\entities\behaviors\InfoPageBehavior;

/**
 * This is the model class for table "shop_info_pages".
 *
 * @property int $id
 * @property string $name
 * @property string $title
 * @property string $slug
 * @property string $main_content
 * @property string $description
 * @property int $sort
 * @property int $sys_id
 * @property string $slider_name
 * @property string $additional_data
 * @property array $meta_json
 * @property string $created_at
 * @property string $update_at
 * @property int $status
 * @property Meta $meta
 *
 * @property Slider $sliderName
 * @property InfoPageStatus $statuses
 */
class InfoPage extends ActiveRecord
{
    public $meta;
    public $statuses = [];

    const STATUS_ACTIVE = 1;
    const STATUS_DRAFT = 0;

    public static function create($name, $title, $slug, $main_content, $description, $sort, $additional_data, Meta $meta): self
    {
        $infoPage = new static();
        $infoPage->name = $name;
        $infoPage->title = $title;
        $infoPage->slug = $slug;
        $infoPage->main_content = $main_content;
        $infoPage->description = $description;
        $infoPage->sort = $sort;
        $infoPage->addStatus(InfoPageStatus::PAGE_OTHER);
        $infoPage->additional_data = $additional_data;
        $infoPage->status = self::STATUS_ACTIVE;
        $infoPage->created_at = time();
        $infoPage->meta = $meta;
        return $infoPage;
    }

    public function edit($name, $title, $slug, $main_content, $description, $sort, $additional_data, Meta $meta): void
    {
        $this->name = $name;
        $this->title = $title;
        $this->slug = $slug;
        $this->main_content = $main_content;
        $this->description = $description;
        $this->sort = $sort;
        $this->additional_data = $additional_data;
        $this->update_at = time();
        $this->meta = $meta;
    }

    public function isActive(): bool
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function isDraft(): bool
    {
        return $this->status == self::STATUS_DRAFT;
    }

    public function activate(): void
    {
        if ($this->isActive()) {
            throw new \DomainException('Info Page is already active.');
        }
        $this->status = self::STATUS_ACTIVE;
    }

    public function draft(): void
    {
        if ($this->isDraft()) {
            throw new \DomainException('Info Page is already draft.');
        }
        $this->status = self::STATUS_DRAFT;
    }

    private function addStatus($value): void
    {
        $this->statuses[] = new InfoPageStatus($value, time());
        $this->sys_id = $value;
    }

    public function changeStatus($value): void
    {
        $this->revokeStatus();
        $this->statuses[] = new InfoPageStatus($value, time());
        $this->sys_id = $value;
    }

    public function revokeStatus(): void
    {
        $statuses = $this->statuses;
        foreach ($statuses as $i => $status) {
            unset($statuses);
            $this->statuses = null;
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{shop_info_pages}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => MetaBehavior::class,
                'attribute' => 'meta',
                'jsonAttribute' => 'meta_json',
            ],
            [
                'class' => InfoPageBehavior::class,
                'attribute' => 'statuses',
                'jsonAttribute' => 'sys_statuses_json',
            ]
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSliderName()
    {
        return $this->hasOne(Slider::class, ['name' => 'slider_name']);
    }
}
