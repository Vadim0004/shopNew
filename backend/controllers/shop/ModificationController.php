<?php

namespace backend\controllers\shop;

use shop\forms\manage\Shop\Product\ModificationForm;
use shop\services\manage\Shop\ProductManageService;
use Yii;
use shop\entities\Shop\Product\Product;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ModificationController extends Controller
{
    private $productManageService;

    public function __construct($id, $module, ProductManageService $productManageService, $config = [])
    {
        $this->productManageService = $productManageService;
        parent::__construct($id, $module, $config);
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->redirect('shop/product');
    }

    /**
     * @param $product_id
     * @return mixed
     */
    public function actionCreate($product_id)
    {
        $product = $this->findModel($product_id);
        $form = new ModificationForm();
        if (Yii::$app->request->isPost && $form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->productManageService->addModification($product->id, $form);
                return $this->redirect(['shop/product/view', 'id' => $product->id, '#' => 'modifications']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'product' => $product,
            'model' => $form,
        ]);
    }

    /**
     * @param integer $product_id
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($product_id, $id)
    {
        $product = $this->findModel($product_id);
        $modification = $product->getModification($id);
        $form = new ModificationForm($modification);
        if (Yii::$app->request->isPost && $form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->productManageService->editModification($product->id, $modification->id, $form);
                return $this->redirect(['shop/product/view', 'id' => $product->id, '#' => 'modifications']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'product' => $product,
            'model' => $form,
            'modification' => $modification,
        ]);
    }

    /**
     * @param $product_id
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($product_id, $id)
    {
        $product = $this->findModel($product_id);
        try {
            $this->productManageService->removeModification($product->id, $id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['shop/product/view', 'id' => $product->id, '#' => 'modifications']);
    }

    /**
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): Product
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}