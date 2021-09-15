<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


use App\Entity\Categoria;
use App\Form\Type\CategoriaTipoType;

class CategoriaCreateType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder    
            ->add("categoria", TextType::class, ["mapped" => false])
            ->add("text", TextAreaType::class, ["mapped" => false])
            ->add("btnEnviar", SubmitType::class, ["label"=>"Buscar"]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([ 'data_class' => Categoria::class, ]);
    }
}