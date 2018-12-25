<?php

namespace backend\controllers\shop;

use shop\forms\manage\Shop\SliderForm;
use yii;
use yii\web\Controller;
use shop\entities\Shop\Slider;
use yii\filters\VerbFilter;
use shop\services\manage\Shop\SliderManageService;
use backend\forms\Shop\SliderSearch;
use shop\repositories\NotFoundException;
use shop\forms\manage\Shop\Product\PhotosForm;

class SliderController extends Controller
{
    private $service;

    public function __construct($id, $module, SliderManageService $service, array $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
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
        $searchModel = new SliderSearch();
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
        $infoPage = $this->findModel($id);
        $photosForm = new PhotosForm();

        if ($photosForm->load(Yii::$app->request->post()) && $photosForm->validate()) {
            try {
                $this->service->addPhoto($infoPage->id, $photosForm);
                return $this->redirect(['view', 'id' => $infoPage->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('view', [
            'slider' => $infoPage,
            'photosForm' => $photosForm,
        ]);
    }

    /**
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new SliderForm();
        if (Yii::$app->request->isPost && $form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $slider = $this->service->create($form);
                return $this->redirect(['view', 'id' => $slider->id]);
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
        $slider = $this->findModel($id);
        $form = new SliderForm($slider);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($slider->id, $form);
                return $this->redirect(['view', 'id' => $slider->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $form,
            'slider' => $slider,
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
     * @return Slider the loaded model
     * @throws NotFoundException if the model cannot be found
     */
    protected function findModel($id): Slider
    {
        if (($model = Slider::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundException('The requested page does not exist.');
    }
}