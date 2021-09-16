<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;


use App\Entity\Categoria;
use App\Form\Type\CategoriaTipoType;

class CategoriaCreateType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder    
            ->add("categoria", TextType::class, ["mapped" => false])
            ->add("text", TextAreaType::class, ["mapped" => false])
            ->add("imagen", FileType::class, [
                'mapped'=>false,
                'required'=>false,
                'constraints'=>[new File([
                    'maxSize'=>'2048k',
                    'mimeTypes'=>['image/png', 'image/jpeg', 'image/gif', ],
                    'mimeTypesMessage'=>'El documento tiene que estar en formato jpg, png o gif',
                ])]
            ])
            ->add("btnEnviar", SubmitType::class, ["label"=>"Buscar"]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([ 'data_class' => Categoria::class, ]);
    }
}