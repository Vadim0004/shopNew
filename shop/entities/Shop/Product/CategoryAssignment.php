<?php

namespace shop\entities\Shop\Product;

use shop\entities\Shop\Category;
use yii\db\ActiveRecord;

/**
 * @property int $product_id
 * @property int $category_id
 */
class CategoryAssignment extends ActiveRecord
{
    public static function create($categoryId): self
    {
        $assignment = new static();
        $assignment->category_id = $categoryId;
        return $assignment;
    }

    public function isForCategory($id): bool
    {
        return $this->category_id == $id;
    }

    public static function tableName()
    {
        return '{{%shop_category_assignments}}';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

}
