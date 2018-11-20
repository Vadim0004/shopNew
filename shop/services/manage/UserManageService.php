<?php

namespace shop\services\manage;

use shop\entities\User\User;
use shop\forms\manage\User\UserCreateForm;
use shop\forms\manage\User\UserEditForm;
use shop\repositories\UserRepository;
use shop\services\RoleManager;
use shop\services\TransactionManager;

class UserManageService
{
    private $userRepository;
    private $roles;
    private $transaction;

    public function __construct(UserRepository $userRepository, RoleManager $roles, TransactionManager $transaction)
    {
        $this->userRepository = $userRepository;
        $this->roles = $roles;
        $this->transaction = $transaction;
    }

    public function create(UserCreateForm $form): User
    {
        $user = User::create(
            $form->username,
            $form->email,
            $form->password
        );
        $this->transaction->wrap(function () use ($user, $form) {
            $this->userRepository->save($user);
            $this->roles->assign($user->id, $form->role);
        });
        return $user;
    }

    public function edit($id, UserEditForm $form): void
    {
        $user = $this->userRepository->get($id);
        $user->edit(
            $form->username,
            $form->email
        );

        $this->transaction->wrap(function () use ($user, $form) {
            $this->userRepository->save($user);
            $this->roles->assign($user->id, $form->role);
        });
    }

    public function assignRole($id, $role): void
    {
        $user = $this->userRepository->get($id);
        $this->roles->assign($user->id, $role);
    }

    public function remove($id): void
    {
        $user = $this->userRepository->get($id);
        $this->userRepository->remove($user);
    }

}