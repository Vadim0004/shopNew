<?php

namespace shop\entities\User;

use shop\entities\Shop\Product\Product;

/**
 * This is the model class for table "user_wishlist_items".
 *
 * @property int $user_id
 * @property int $product_id
 *
 * @property Product $product
 * @property User $user
 */
class WishlistItem extends \yii\db\ActiveRecord
{

    public static function create($productId): self
    {
        $item = new static();
        $item->product_id = $productId;
        return $item;
    }

    public function isForProduct($id): bool
    {
        return $this->product_id == $id;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_wishlist_items}}';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
