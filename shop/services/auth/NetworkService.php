<?php

namespace shop\services\auth;

use shop\repositories\UserRepository;
use shop\entities\User\User;

class NetworkService
{
    private $userRepositories;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepositories = $userRepository;
    }

    public function auth($network, $identity): User
    {
        if ($user = $this->userRepositories->findByNetworkIdentity($network, $identity)) {
            return $user;
        }

        $user = User::signupByNetwork($network, $identity);
        $this->userRepositories->save($user);
        return $user;
    }

    public function attach($id, $network, $identity): void
    {
        if ($this->userRepositories->findByNetworkIdentity($network, $identity)) {
            throw new \DomainException('Network is already signed up');
        }

        $user = $this->userRepositories->get($id);
        $user->attachNetwork($network, $identity);
        $this->userRepositories->save($user);
    }
}