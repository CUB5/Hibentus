<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use App\Entity\Categoria;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CategoriaType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder    
            ->add("nombre", TextType::class)
            ->add("comentario", TextareaType::class)
            ->add("btnEnviar", SubmitType::class, ["label"=>"Guardar"]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([ 'data_class' => Categoria::class, ]);
    }
}