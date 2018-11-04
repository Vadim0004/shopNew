<?php

namespace frontend\widgets\shop;

use shop\readModels\Shop\ProductReadRepository;
use Yii;
use yii\base\Widget;

class FeaturedProductsWidget extends Widget
{
    public $limit;

    private $products;

    public function __construct(ProductReadRepository $products, $config = [])
    {
        parent::__construct($config);
        $this->products = $products;
    }

    public function run()
    {
        $featuredProd = $this->products->getAllProductsFeatured($this->limit);
        if (!$featuredProd) {
            Yii::$app->session->setFlash('error', 'Featured products is not found');
        }
        return $this->render('featured', [
            'featuredProd' => $featuredProd,
        ]);
    }
}