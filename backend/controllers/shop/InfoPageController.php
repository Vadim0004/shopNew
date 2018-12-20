<?php

namespace backend\controllers\shop;

use yii;
use shop\repositories\NotFoundException;
use yii\web\Controller;
use shop\entities\Shop\InfoPage\InfoPage;
use backend\forms\Shop\InfoPageSearch;
use shop\forms\manage\Shop\InfoPage\InfoPageForm;
use shop\services\manage\Shop\InfoPageService;
use shop\forms\manage\Shop\InfoPage\InfoPageStatusForm;

class InfoPageController extends Controller
{
    private $service;

    public function __construct($id, $module, InfoPageService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        $searchModel = new InfoPageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'infoPage' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $form = new InfoPageForm($this->service->sliderRepository);
        if (Yii::$app->request->isPost && $form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $infoPage = $this->service->create($form);
                return $this->redirect(['view', 'id' => $infoPage->id]);
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
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $infoPage = $this->findModel($id);
        $form = new InfoPageForm($this->service->sliderRepository, $infoPage);
        if (Yii::$app->request->isPost && $form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($infoPage->id, $form);
                return $this->redirect(['view', 'id' => $infoPage->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'infoPage' => $infoPage,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionActivate($id)
    {
        $infoPage = $this->findModel($id);
        try {
            $this->service->activate($infoPage->id);
            return $this->redirect(['view', 'id' => $infoPage->id]);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDraft($id)
    {
        $infoPage = $this->findModel($id);
        try {
            $this->service->draft($infoPage->id);
            return $this->redirect(['view', 'id' => $infoPage->id]);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionEditStatus($id)
    {
        $infoPage = $this->findModel($id);
        $form = new InfoPageStatusForm($infoPage);
        if (Yii::$app->request->isPost && $form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->changeStatusSysId($infoPage->id, $form);
                return $this->redirect(['view', 'id' => $infoPage->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->renderAjax('status', [
            'model' => $form,
            'infoPage' => $infoPage,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $this->service->remove($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    /**
     * @param integer $id
     * @return InfoPage the loaded model
     * @throws NotFoundException if the model cannot be found
     */
    protected function findModel($id): InfoPage
    {
        if (($model = InfoPage::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundException('The requested page does not exist.');
    }
}