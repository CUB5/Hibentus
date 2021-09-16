<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class UsuarioRegistroType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder    
            ->add("username", TextType::class)
            ->add("password", TextType::class)
            ->add("nombre", TextType::class)
            ->add("email", TextType::class)
            ->add("btnEnviar", SubmitType::class, ["label"=>"Crear"]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([ 'data_class' => User::class, ]);
    }
}