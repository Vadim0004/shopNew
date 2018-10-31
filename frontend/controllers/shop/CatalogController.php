<?php

namespace frontend\controllers\shop;

use shop\readModels\Shop\BrandReadRepository;
use shop\readModels\Shop\CategoryReadRepository;
use shop\readModels\Shop\ProductReadRepository;
use shop\readModels\Shop\TagReadRepository;
use yii\web\Controller;

class CatalogController extends Controller
{
    public $layout = 'catalog';

    private $products;
    private $categories;
    private $brands;
    private $tags;

    public function __construct
    ($id,
     $module,
     ProductReadRepository $products,
     CategoryReadRepository $categories,
     BrandReadRepository $brands,
     TagReadRepository $tags,
     $config = []
    )
    {
        $this->categories = $categories;
        $this->brands = $brands;
        $this->tags = $tags;
        $this->products = $products;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        $dataProvider = $this->products->getAll();
        $category = $this->categories->getRoot();

        return $this->render('index', [
            'category' => $category,
            'dataProvider' => $dataProvider,
        ]);
    }
}