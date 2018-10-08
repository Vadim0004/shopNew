<?php

/* @var $this yii\web\View */
/* @var $user \shop\entities\User\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/signup/confirmm', 'token' => $user->email_confirm_token]);
?>
    Hello <?= $user->username ?>,

    Follow the link below to reset your password:

<?= $resetLink ?>