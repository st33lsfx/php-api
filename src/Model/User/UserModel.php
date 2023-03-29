<?php

namespace App\Model\User;

use App\Entity\User\User;
use App\Validator\User\PasswordRequirements;
use Symfony\Component\Validator\Constraints as Assert;
class UserModel
{
    #[Assert\NotBlank()]
    public string $firstName;
    public ?string $lastName = null;

    #[Assert\NotBlank()]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.'
    )]
    public string $email;
    public ?string $nick = null;

    #[PasswordRequirements()]
    public string $password;

    public static function createFromEntity(User $user): UserModel
    {
        $newUser = new self();

        $newUser->firstName = $user->getFirstName();
        $newUser->lastName = $user->getLastName();
        $newUser->email = $user->getEmail();
        $newUser->nick = $user->getNick();
        $newUser->password = $user->getPassword();

        return $newUser;
    }

}