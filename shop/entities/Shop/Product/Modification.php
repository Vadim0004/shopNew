<?php

namespace shop\entities\Shop\Product;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "shop_modifications".
 *
 * @property int $id
 * @property int $product_id
 * @property string $code
 * @property string $name
 * @property int $price
 * @property int $quantity
 */
class Modification extends ActiveRecord
{

    public static function create($code, $name, $price, $quantity): self
    {
        $modification = new static();
        $modification->code = $code;
        $modification->name = $name;
        $modification->price = $price;
        $modification->quantity = $quantity;
        return $modification;
    }

    public function edit($code, $name, $price, $quantity): void
    {
        $this->code = $code;
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    public function checkout($quantity): void
    {
        if ($quantity > $this->quantity) {
            throw new \DomainException('Only ' . $this->quantity . ' items are available.');
        }
        $this->quantity -= $quantity;
    }

    public function isIdEqualTo($id)
    {
        return $this->id == $id;
    }

    public function isCodeEqualTo($code)
    {
        return $this->code === $code;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%shop_modifications}}';
    }
}
