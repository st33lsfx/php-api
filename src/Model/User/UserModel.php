<?php

namespace App\Model\User;

use App\Entity\User\User;
use Symfony\Component\Validator\Constraints as Assert;
class UserModel
{
    #[Assert\NotBlank()]
    public string $firstName;
    public ?string $lastName = null;
    #[Assert\NotBlank()]
    public string $nick;

    public string $password;

    public static function createFromEntity(User $user): UserModel
    {
        $newUser = new self();

        $newUser->firstName = $user->getFirstName();
        $newUser->lastName = $user->getLastName();
        $newUser->nick = $user->getNick();
        $newUser->password = $user->getPassword();

        return $newUser;
    }

}