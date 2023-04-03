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

        $user = new User();
        $user->setCreateAt(new \DateTimeImmutable('now'));
        $user->setFirstName('admin');
        $user->setLastName('admin');
        $user->setNick('admin');
        $password = $this->hasher->hashPassword($user, 'admin');
        $user->setPassword($password);
        $user->setRoles(['ROLE_ADMIN']);
        $complete_user[] = $user;

        $user1 = new User();
        $user1->setCreateAt(new \DateTimeImmutable('16.11.2022'));
        $user1->setFirstName('test');
        $user1->setLastName('test');
        $user1->setNick('test');
        $password1 = $this->hasher->hashPassword($user, 'test');
        $user1->setPassword($password1);
        $user1->setRoles(['ROLE_ADMIN']);
        $complete_user[] = $user1;

        $user2 = new User();
        $user2->setCreateAt(new \DateTimeImmutable('16.12.2022'));
        $user2->setFirstName('adminTest');
        $user2->setLastName('adminTest');
        $user2->setNick('adminTest');
        $password2 = $this->hasher->hashPassword($user, 'adminTest');
        $user2->setPassword($password2);
        $user2->setRoles(['ROLE_ADMIN']);
        $complete_user[] = $user2;

        $user3 = new User();
        $user3->setCreateAt(new \DateTimeImmutable('16.02.2022'));
        $user3->setFirstName('administrator');
        $user3->setLastName('administrator');
        $user3->setNick('administrator');
        $password3 = $this->hasher->hashPassword($user, 'administrator');
        $user3->setPassword($password3);
        $user3->setRoles(['ROLE_ADMIN']);
        $complete_user[] = $user3;

        $user4 = new User();
        $user4->setCreateAt(new \DateTimeImmutable('05.05.2022'));
        $user4->setFirstName('testovaci');
        $user4->setLastName('testovaci');
        $user4->setNick('testovaci');
        $password4 = $this->hasher->hashPassword($user, 'testovaci');
        $user4->setPassword($password4);
        $user4->setRoles(['ROLE_ADMIN']);
        $complete_user[] = $user4;

        $user5 = new User();
        $user5->setCreateAt(new \DateTimeImmutable('23.02.2021'));
        $user5->setFirstName('kolo');
        $user5->setLastName('maznik');
        $user5->setNick('maznik');
        $password5 = $this->hasher->hashPassword($user, 'kolo');
        $user5->setPassword($password5);
        $user5->setRoles(['ROLE_ADMIN']);
        $complete_user[] = $user5;

        $user6 = new User();
        $user6->setCreateAt(new \DateTimeImmutable('23.04.2022'));
        $user6->setFirstName('skoc');
        $user6->setLastName('dopole');
        $user6->setNick('skoc');
        $password6 = $this->hasher->hashPassword($user, 'dopole');
        $user6->setPassword($password6);
        $user6->setRoles(['ROLE_ADMIN']);
        $complete_user[] = $user6;

        $user7 = new User();
        $user7->setCreateAt(new \DateTimeImmutable('24.01.2019'));
        $user7->setFirstName('Karel');
        $user7->setLastName('Nakládal');
        $user7->setNick('karel-nakladal');
        $password7 = $this->hasher->hashPassword($user, 'karel');
        $user7->setPassword($password7);
        $user7->setRoles(['ROLE_ADMIN']);
        $complete_user[] = $user7;

        $user8 = new User();
        $user8->setCreateAt(new \DateTimeImmutable('11.04.1990'));
        $user8->setFirstName('Tereza');
        $user8->setLastName('Zapapiry');
        $user8->setNick('zapapiry');
        $password8 = $this->hasher->hashPassword($user, 'zapapiry');
        $user8->setPassword($password8);
        $user8->setRoles(['ROLE_ADMIN']);
        $complete_user[] = $user8;

        $user9 = new User();
        $user9->setCreateAt(new \DateTimeImmutable('05.05.1998'));
        $user9->setFirstName('Tomáš');
        $user9->setLastName('Nebojsa');
        $user9->setNick('nebojsa');
        $password9 = $this->hasher->hashPassword($user, 'nebojsa');
        $user9->setPassword($password9);
        $user9->setRoles(['ROLE_ADMIN']);
        $complete_user[] = $user9;

        $user10 = new User();
        $user10->setCreateAt(new \DateTimeImmutable('17.09.2021'));
        $user10->setFirstName('Pavel');
        $user10->setLastName('Kolomazník');
        $user10->setNick('kolomaznik');
        $password10 = $this->hasher->hashPassword($user, 'pavel');
        $user10->setPassword($password10);
        $user10->setRoles(['ROLE_ADMIN']);
        $complete_user[] = $user10;

        foreach ($complete_user as $one_user) {
            $manager->persist($one_user);
        }

        $manager->flush();
    }
}
