<?php

namespace shop\services\auth;

use shop\access\Rbac;
use shop\entities\User\User;
use shop\repositories\UserRepository;
use shop\services\RoleManager;
use shop\services\TransactionManager;
use shop\forms\auth\SignupForm;
use yii\mail\MailerInterface;
use Yii;

class SignupService
{
    private $mailer;
    private $userRepository;
    private $adminEmail;
    private $roles;
    private $transaction;

    public function __construct(
        $adminEmail,
        MailerInterface $mailer,
        UserRepository $userRepository,
        RoleManager $roles,
        TransactionManager $transaction)
    {
        $this->adminEmail = $adminEmail;
        $this->userRepository = $userRepository;
        $this->mailer = $mailer;
        $this->roles = $roles;
        $this->transaction = $transaction;
    }

    public function signup(SignupForm $form)
    {
        $user = User::requestSignup(
            $form->username,
            $form->email,
            $form->password
        );

        $this->transaction->wrap(function () use ($user) {
            $this->userRepository->save($user);
            $this->roles->assign($user->id, Rbac::ROLE_USER);
        });

        $sent = $this->mailer
            ->compose(
                ['html' => 'auth/signup/emailConfirmToken-html', 'text' => 'auth/signup/emailConfirmToken-text'],
                ['user' => $user]
            )
            ->setFrom($this->adminEmail)
            ->setTo($form->email)
            ->setSubject('Signup confirm for ' . Yii::$app->name)
            ->send();
        if (!$sent) {
            throw new \RuntimeException('Email sending error');
        }
    }

    public function confirm($token): void
    {
        if (empty($token)) {
            throw new \DomainException('Empty confirm token.');
        }
        $user = $this->userRepository->getByEmailConfirmToken($token);
        $user->confirmSignup();
        $this->userRepository->save($user);
    }

}