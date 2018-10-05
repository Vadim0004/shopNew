<?php

namespace common\bootstrap;

use shop\services\auth\PasswordResetService;
use shop\services\auth\SignupService;
use shop\services\ContactService;
use yii\base\BootstrapInterface;
use yii\di\Instance;
use yii\mail\MailerInterface;
use Yii;

class SetUp implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $container = \Yii::$container;
        /*
        $container->setSingleton(PasswordResetService::class, function () use ($app) {
            return new PasswordResetService([Yii::$app->params['adminEmail'] => Yii::$app->name . ' robot']);
        });
        */

        $container->setSingleton(MailerInterface::class, function () use ($app) {
            return $app->mailer;
        });

        $container->setSingleton(PasswordResetService::class, [], [
            [Yii::$app->params['adminEmail'] => Yii::$app->name . ' robot'],
            Instance::of(MailerInterface::class)
        ]);

        $container->setSingleton(SignupService::class, [], [
            $app->params['adminEmail'],
            Instance::of(MailerInterface::class)
        ]);

        $container->setSingleton(ContactService::class, [], [
            $app->params['adminEmail'],
            $app->params['adminEmail'],
            Instance::of(MailerInterface::class)
        ]);
    }
}