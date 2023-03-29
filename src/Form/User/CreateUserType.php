<?php

namespace App\Form\User;

use App\Model\User\UserModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateUserType extends AbstractType
{

    public function userForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'firstName',
                TextType::class,
                [
                    'label' => 'Jméno'
                ]
            )
            ->add(
                'lastName',
                TextType::class,
                [
                    'label' => 'Příjmení'
                ]
            )
            ->add(
                'nick',
                TextType::class,
                [
                   'label' => 'Přezdívka'
                ]
            )
            ->add(
                'email',
                TextType::class,
                [
                    'label' => 'Email'
                ]
            )
            ->add(
                'password',
                TextType::class,
                [
                    'label' => 'Heslo'
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