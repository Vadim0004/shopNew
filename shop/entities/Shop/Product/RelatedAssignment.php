<?php

namespace shop\entities\Shop\Product;

use yii\db\ActiveRecord;

/**
 * @property int $product_id
 * @property int $related_id
 */
class RelatedAssignment extends ActiveRecord
{
    public static function create($productId): self
    {
        $assignment = new static();
        $assignment->related_id = $productId;
        return $assignment;
    }
    public function isForProduct($id): bool
    {
        return $this->related_id == $id;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%shop_related_assignments}}';
    }
}
