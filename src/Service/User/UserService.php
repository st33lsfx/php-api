<?php

namespace App\Service\User;

use App\Entity\User\User;
use App\Model\User\UserModel;
use App\Repository\User\UserRepository;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
    }

    public function createUser(UserModel $userModel): User
    {
        $newUser = new User();

        $newUser->setFirstName($userModel->firstName);
        $newUser->setLastName($userModel->lastName);
        $newUser->setNick($userModel->nick);
        $newUser->setPassword($userModel->password);

        return $newUser;
    }

}