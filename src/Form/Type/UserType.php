<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

use App\Entity\User;


class UserType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder    
            ->add('username', TextType::class)
            ->add('roles', ChoiceType::class, [
                'choices'=>[
                    "Usuario"=>"ROLE_USER",
                    "Organizador"=>"ROLE_EDITOR",
                    "Administrador"=>"ROLE_ADMIN",
                ],
                "mapped"=>false]
            )
            ->add('plainPass', RepeatedType::class, [
                "mapped"=>false,
                "type"=>PasswordType::class,
                "first_option"=>["label"=>"Contraseña"],
                "second_option"=>["label"=>"Repite contraseña"] 
            ])
            ->add("nombre", TextType::class)
            ->add("email", EmailType::class)
            ->add("btnEnviar", SubmitType::class, [
                "label"=>"Guardar"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([ 'data_class' => User::class, ]);
    }

}