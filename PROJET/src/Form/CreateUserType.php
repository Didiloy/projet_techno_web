<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username',
                TextType::class,
                [
                    'label' => 'Name',
                    'attr' => ['placeholder' => 'John Doe'],
                ])
            ->add('password',
                PasswordType::class,
                [
                    'label' => 'Password',
                ])
            ->add('birthdate',
                DateType::class,
                [
                    'label' => 'Birth date',
                    'widget' => 'single_text',
                ])
//            ->add('roles',
//                CollectionType::class,
//                [
////                    'entry_type' => TextType::class,
//                    'entry_type'   => ChoiceType::class,
//                    'entry_options'  => [
//                        'choices'  => [
//                            'Client' => 'ROLE_CLIENT',
//                            'Admin'     => 'ROLE_ADMIN',
//                            'Super Admin'    => 'ROLE_SUPER_ADMIN',
//                        ],
//                    ],
//                ]
//            )
            ->add('save',
                SubmitType::class,
                ['label' => 'Save'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
