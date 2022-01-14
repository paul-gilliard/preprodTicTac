<?php

namespace App\Form;

use App\Entity\User;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Username',TypeTextType::class, array(
                'attr' => array(
                    'class'=>"form-control",
                     'id'=>"InputUsername"
                )
            ))
            ->add('email', EmailType::class, array(
                'attr' => array(
                    'class'=>"form-control",
                     'id'=>"InputUsername"
                )
            ))
            ->add('password', PasswordType::class, array(
                'attr' => array(
                    'class'=>"form-control",
                     'id'=>"InputUsername"
                )
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
