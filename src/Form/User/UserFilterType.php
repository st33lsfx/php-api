<?php

namespace App\Form\User;

use App\Model\User\UserFilter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserFilterType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'page'
            )
            ->add(
                'limit'
            )
            ->add(
                'sortByNick',
                ChoiceType::class,
                [
                    'choices' => [
                        'False' => false,
                        'True' => true
                    ]
                ]
            )
            ->add(
                'sortDirection',
                ChoiceType::class,
                [
                    'choices' => [
                        'ASC' => 'ASC',
                        'DESC' => 'DESC',
                    ]
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserFilter::class,
            'csrf_protection' => false,
        ]);
    }

}