<?php

namespace common\bootstrap;

use shop\services\auth\PasswordResetService;
use shop\services\auth\SignupService;
use shop\services\ContactService;
use yii\base\BootstrapInterface;
use yii\di\Instance;
use yii\mail\MailerInterface;
use shop\cart\cost\calculator\DynamicCost;
use shop\cart\Cart;
use shop\cart\cost\calculator\SimpleCost;
use shop\cart\storage\CookieStorage;
use shop\cart\storage\SessionStorage;
use yii\rbac\ManagerInterface;
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

        $container->setSingleton(ManagerInterface::class, function () use ($app) {
            return $app->authManager;
        });

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

        $container->setSingleton(Cart::class, function () {
            return new Cart(
                new CookieStorage('cart', 3600),
                //new SessionStorage('cart'),
                new DynamicCost(new SimpleCost())
            );
        });
    }
}