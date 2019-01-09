<?php

namespace backend\controllers\shop;

use shop\entities\Shop\Configuration;
use yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use backend\forms\Shop\ConfigurationSearch;
use shop\services\manage\Shop\ConfigurationManageService;
use shop\repositories\NotFoundException;
use shop\forms\manage\Shop\ConfigurationForm;

class ConfigurationController extends Controller
{
    private $configurationManageService;

    public function __construct($id, $module, ConfigurationManageService $configurationManageService, array $config = [])
    {
        $this->configurationManageService = $configurationManageService;
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
                    'delete' => ['POST']
                ],
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ConfigurationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = [
            'pageSizeLimit' => [10, 100],
            'pageSize' => 10,
        ];
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
            'configuration' => $this->findModel($id),
        ]);
    }

    /**
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new ConfigurationForm();
        if (Yii::$app->request->isPost && $form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $configuration = $this->configurationManageService->create($form);
                return $this->redirect(['view', 'id' => $configuration->id]);
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
        $configuration = $this->findModel($id);
        $form = new ConfigurationForm($configuration);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->configurationManageService->edit($configuration->id, $form);
                return $this->redirect(['view', 'id' => $configuration->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'brand' => $configuration,
        ]);
    }


    /**
     * @param integer $id
     * @return Configuration the loaded model
     * @throws NotFoundException if the model cannot be found
     */
    protected function findModel($id): Configuration
    {
        if (($model = Configuration::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundException('The requested page does not exist.');
    }
}