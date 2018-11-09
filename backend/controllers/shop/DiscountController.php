<?php

namespace backend\controllers\shop;

use backend\forms\Shop\DiscountSearch;
use shop\entities\Shop\Discount;
use shop\forms\manage\Shop\DiscountForm;
use yii\web\Controller;
use shop\repositories\NotFoundException;
use Yii;

class DiscountController extends Controller
{
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
            echo '<pre>';
            var_dump($form);
            echo '</pre>';
            die("\n");
        } else {

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

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}