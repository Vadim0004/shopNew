<?php

namespace shop\forms\manage\Shop\Product;

use shop\entities\Shop\Product\Product;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class RelatedProductForm extends Model
{
    public $products = [];

    private $_productList;

    public function __construct(Product $productList = null, $config = [])
    {
        if ($productList) {
            $this->products = ArrayHelper::getColumn($productList->relatedAssignments, 'related_id');
            $this->_productList = $productList;
        }
        parent::__construct($config);
    }

    public function productsList(): array
    {
        $productList = ArrayHelper::map(Product::find()->asArray()->all(), 'id', 'name');
        return $productList;
    }

    public function rules(): array
    {
        return [
            ['products', 'each', 'rule' => ['integer']],
            ['products', 'default', 'value' => []],
        ];
    }

}