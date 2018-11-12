<?php

namespace backend\controllers\shop;

use backend\forms\Shop\DiscountSearch;
use shop\entities\Shop\Discount;
use shop\forms\manage\Shop\DiscountForm;
use shop\services\manage\Shop\DiscountManageService;
use yii\web\Controller;
use shop\repositories\NotFoundException;
use Yii;

class DiscountController extends Controller
{
    public $service;

    public function __construct($id, $module, DiscountManageService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        $searchModel = new DiscountSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $form = new DiscountForm();

        if (Yii::$app->request->isPost && $form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $discount = $this->service->create($form);
                return $this->redirect(['view', 'id' => $discount->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * @param integer $id
     * @return Discount the loaded model
     * @throws NotFoundException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Discount::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundException('The requested page does not exist.');
    }
}