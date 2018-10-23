<?php

namespace shop\entities\Shop\Product;

use shop\entities\Shop\Characteristic;
use yii\db\ActiveRecord;

/**
 * @property int $product_id
 * @property int $characteristic_id
 * @property string $value
 *
 * @property Characteristic $characteristic
 */
class Value extends ActiveRecord
{

    public static function create($characteristicId, $value): self
    {
        $object = new static();
        $object->characteristic_id = $characteristicId;
        $object->value = $value;
        return $object;
    }

    public static function blank($characteristicId): self
    {
        $object = new static();
        $object->characteristic_id = $characteristicId;
        return $object;
    }

    public function isForCharacteristic($id): bool
    {
        return $this->characteristic_id == $id;
    }

    public function change($value): void
    {
        $this->value = $value;
    }

    public static function tableName()
    {
        return '{{%shop_values}}';
    }

    public function getCharacteristic()
    {
        return $this->hasOne(Characteristic::class, ['id' => 'characteristic_id']);
    }
}
