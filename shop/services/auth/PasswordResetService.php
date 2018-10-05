<?php

namespace shop\services\auth;

use shop\repositories\UserRepository;
use shop\forms\auth\PasswordResetRequestForm;
use shop\forms\auth\ResetPasswordForm;
use Yii;
use yii\mail\MailerInterface;

class PasswordResetService
{
    private $supportEmail;
    /**
     * @var MailerInterface
     */
    private $mailer;
    private $userRepository;

    public function __construct($supportEmail, MailerInterface $mailer, UserRepository $userRepository)
    {
        $this->mailer = $mailer;
        $this->supportEmail = $supportEmail;
        $this->userRepository = $userRepository;
    }

    public function request(PasswordResetRequestForm $form): void
    {
        $user = $this->userRepository->getByEmail($form->email);

        if (!$user->isActive()) {
            throw new \DomainException('User is not active');
        }

        $user->requestPasswordReset();
        $this->userRepository->save($user);

        $sent = $this
            ->mailer
            ->compose(
                ['html' => 'auth/reset/passwordResetToken-html', 'text' => 'auth/reset/passwordResetToken-text'],
                ['user' => $user]
            )
            ->setFrom($this->supportEmail)
            ->setTo($user->email)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();

        if (!$sent) {
            throw new \RuntimeException('Sending Error');
        }
    }

    public function validateToken($token): void
    {
        if (empty($token) || !is_string($token)) {
            throw new \DomainException('Password reset token cannot be blank.');
        }
        if (!$this->userRepository->existsByPasswordResetToken($token)) {
            throw new \DomainException('Wrong password reset token.');
        }
    }

    public function reset(string $token, ResetPasswordForm $form): void
    {
        $user = $this->userRepository->getByPasswordResetToken($token);
        $user->resetPassword($form->password);
        $this->userRepository->save($user);
    }
}