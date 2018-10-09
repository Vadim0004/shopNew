<?php

namespace frontend\controllers\cabinet;

use yii\web\Controller;
use shop\forms\User\ProfileEditForm;
use yii;
use shop\entities\User\User;
use shop\repositories\NotFoundException;
use shop\services\cabinet\ProfileService;

class ProfileController extends Controller
{
    private $profileService;

    public function __construct($id, $module, ProfileService $profileService, $config = [])
    {
        $this->profileService = $profileService;
        parent::__construct($id, $module, $config);
    }

    public function actionEdit()
    {
        $user = $this->findModel(Yii::$app->user->id);

        $form = new ProfileEditForm($user);
        if (Yii::$app->request->isPost && $form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->profileService->edit($user->id, $form);
                Yii::$app->session->setFlash('success', 'You change your email!');
                return $this->redirect(['/cabinet/default/index', 'id' => $user->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('edit', [
            'model' => $form,
            'user' => $user,
        ]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}