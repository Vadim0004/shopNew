<?php

namespace shop\services\auth;

use shop\entities\User;
use shop\repositories\UserRepository;
use shop\forms\auth\SignupForm;
use yii\mail\MailerInterface;
use Yii;

class SignupService
{
    private $mailer;
    private $userRepository;
    private $adminEmail;

    public function __construct($adminEmail, MailerInterface $mailer, UserRepository $userRepository)
    {
        $this->adminEmail = $adminEmail;
        $this->userRepository = $userRepository;
        $this->mailer = $mailer;
    }

    public function signup(SignupForm $form)
    {
        $user = User::requestSignup(
            $form->username,
            $form->email,
            $form->password
        );
        $this->userRepository->save($user);
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