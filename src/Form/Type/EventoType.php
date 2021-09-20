<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\FormBuilder;

use App\Entity\Evento;
use App\Form\Type\CategoriaTipoType;
use App\Form\Type\UsuarioTipoType;


class EventoType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder    
            ->add('nombre', TextType::class)
            ->add('fecha_inicio', DateTimeType::class)
            ->add('fecha_fin', DateTimeType::class)
            ->add('descripcion', TextareaType::class)
            ->add('localizacion', TextType::class)
            ->add('imagen', FileType::class, [
                'mapped'=>false,
                'required'=>false,
                'constraints'=>[new File([
                    'maxSize'=>'2048k',
                    'mimeTypes'=>['image/png', 'image/jpeg', 'image/gif', ],
                    'mimeTypesMessage'=>'El documento tiene que estar en formato jpg, png o gif',
                ])]
            ])
            ->add('idCategoria', CategoriaTipoType::class)
            ->add('idUser', UserTipoType::class)
            ->add('btnEnviar', SubmitType::class, ["label"=>"Guardar"]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([ 'data_class' => Evento::class, ]);
    }

}

?>