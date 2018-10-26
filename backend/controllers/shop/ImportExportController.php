<?php

namespace backend\controllers\shop;

use shop\forms\manage\Shop\Product\ImportForm;
use shop\services\manage\Shop\ProductManageService;
use yii\web\Controller;
use Yii;

class ImportExportController extends Controller
{
    private $productManageService;

    public function __construct($id, $module, ProductManageService $productManageService, array $config = [])
    {
        $this->productManageService = $productManageService;
        parent::__construct($id, $module, $config);
    }

    public function actionImportProduct()
    {
        $form = new ImportForm();
        if (Yii::$app->request->isPost && $form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->productManageService->importProduct($form);
                return $this->redirect(['shop/product/index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('import-product', [
            'model' => $form,
        ]);
    }
}