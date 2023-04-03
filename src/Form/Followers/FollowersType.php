<?php

namespace App\Form\Followers;

use App\Entity\User\User;
use App\Repository\User\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FollowersType extends AbstractType
{
    private UserRepository $userRepository;
    public function __construct( UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function followersForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'createAt',
                \DateTimeImmutable::class,
                [
                    'label' => 'created_at'
                ]
            )
            ->add(
                'Follow',
                EntityType::class,
                [
                    'label' => 'Follow',
                    'attr' => ['class' => 'form-control'],
                    'class' => User::class,
                    'choice_label' => function ($user) {
                        return $user->getFirstName() . ' ' . $user->getLastName();
                    },
                    'choices' => $this->userRepository->findAll(),
                    'required' => false
                ]
            )
            ->add(
                'Follower',
                EntityType::class,
               [
                   'label' => 'Follower',
                   'attr' => ['class' => 'form-control'],
                   'class' => User::class,
                   'choice_label' => function ($user) {
                       return $user->getFirstName() . ' ' . $user->getLastName();
                   },
                   'choices' => $this->userRepository->findAll(),
                   'required' => false
               ]
            );
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserModel::class,
        ]);
    }

}