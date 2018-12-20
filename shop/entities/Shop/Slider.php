<?php

namespace shop\entities\Shop;

use shop\entities\Shop\InfoPage\InfoPage;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "shop_sliders".
 *
 * @property int $id
 * @property string $name
 * @property string $file
 * @property string $comment
 *
 * @property InfoPage[] $shopInfoPages
 */
class Slider extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shop_sliders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'file'], 'required'],
            [['name', 'file', 'comment'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShopInfoPages()
    {
        return $this->hasMany(InfoPage::class, ['slider_name' => 'name']);
    }
}
