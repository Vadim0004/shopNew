<?php

namespace frontend\controllers\auth;

use shop\forms\auth\SignupForm;
use shop\services\auth\SignupService;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;

class SignupController extends Controller
{
    public $layout = 'cabinet';

    private $signupService;

    public function __construct($id, $module, SignupService $signupService, $config = [])
    {
        $this->signupService = $signupService;
        parent::__construct($id, $module, $config);
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['request'],
                'rules' => [
                    [
                        'actions' => ['request'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionRequest()
    {
        $form = new SignupForm();
        if (Yii::$app->request->isPost && $form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->signupService->signup($form);
                Yii::$app->session->setFlash('success', 'Check your email for further instructions');
                return $this->goHome();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('request', [
            'model' => $form,
        ]);
    }

    /**
     * @param $token
     * @return mixed
     */
    public function actionConfirm($token)
    {
        try {
            $this->signupService->confirm($token);
            Yii::$app->session->setFlash('success', 'Your email is confirmed');
            return $this->redirect(['auth/auth/login']);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->goHome();
    }
}