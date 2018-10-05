<?php

namespace frontend\controllers;

use yii\web\Controller;
use shop\services\ContactService;
use shop\forms\ContactForm;
use Yii;

class ContactController extends Controller
{
    private $contactService;

    public function __construct($id, $module, ContactService $contactService, $config = [])
    {
        $this->contactService = $contactService;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        $form = new ContactForm();
        if (Yii::$app->request->isPost && $form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->contactService->send($form);
                Yii::$app->session->setFlash('success', 'Thank for contacting us');
                return $this->goHome();
            } catch (\Exception $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', 'There was an error sending your message');
            }
            return $this->refresh();
        }

        return $this->render('index', [
            'model' => $form,
        ]);
    }

}