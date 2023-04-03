<?php

namespace App\Service\User;

use App\Entity\User\User;
use App\Model\User\UserModel;

class UserService
{

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