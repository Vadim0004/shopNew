<?php

namespace shop\services\auth;


use shop\forms\auth\LoginForm;
use shop\entities\User\User;
use shop\repositories\UserRepository;

class AuthService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function auth(LoginForm $form): User
    {
        $user = $this->userRepository->findByUsernameOrEmail($form->username);
        if (!$user || !$user->isActive() || !$user->validatePassword($form->password)) {
            throw new \DomainException('Undefined user or password');
        }
        return $user;
    }

}