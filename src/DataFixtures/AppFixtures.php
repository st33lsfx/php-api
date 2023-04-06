<?php

namespace App\DataFixtures;

use App\Entity\User\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {

        for($i = 1; $i <= 50; $i++) {
            $user = new User();
            $user->setFirstName('user' . $i);
            $user->setLastName( 'name-' . $i);
            $user->setNick('admin' . $i);
            $user->setPassword($this->hasher->hashPassword($user, 'password'));
            $user->setRoles(['ROLE_USER']);
            $user->setCreateAt(new \DateTimeImmutable('now'));

            $users[] = $user;
        }

        foreach ($users as $user) {
            $manager->persist($user);
        }

        $manager->flush();

    }
}
