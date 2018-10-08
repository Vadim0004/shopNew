<?php

namespace shop\services\manage;

use shop\entities\User\User;
use shop\forms\manage\User\UserCreateForm;
use shop\forms\manage\User\UserEditForm;
use shop\repositories\UserRepository;

class UserManageService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create(UserCreateForm $form): User
    {
        $user = User::create(
            $form->username,
            $form->email,
            $form->password
        );
        $this->userRepository->save($user);
        return $user;
    }

    public function edit($id, UserEditForm $form): void
    {
        $user = $this->userRepository->get($id);
        $user->edit(
            $form->username,
            $form->email
        );
        $this->userRepository->save($user);
    }

    public function remove($id): void
    {
        $user = $this->userRepository->get($id);
        $this->userRepository->remove($user);
    }

}