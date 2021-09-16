<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use App\Entity\User;

class RoleChooseType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('roles', ChoiceType::class, [
                'choices'=>[
                    "Usuario"=>"ROLE_USER",
                    "Organizador"=>"ROLE_EDITOR",
                    "Administrador"=>"ROLE_ADMIN",
                ],
                "mapped"=>false]
            )
            ->add('btnEnviar', SubmitType::class, ["label"=>"Guardar"]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([ 'data_class' => User::class, ]);
    }

}