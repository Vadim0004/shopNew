<?php

namespace shop\services\cabinet;

use shop\forms\User\ProfileEditForm;
use shop\repositories\UserRepository;


class ProfileService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function edit($id, ProfileEditForm $form): void
    {
        $user = $this->userRepository->get($id);
        $user->editProfile($form->email);
        $this->userRepository->save($user);
    }
}