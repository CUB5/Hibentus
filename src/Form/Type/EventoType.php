<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

use App\Entity\Evento;
use App\Form\Type\CategoriaTipoType;
use App\Form\Type\UsuarioTipoType;
use Symfony\Component\Form\FormBuilder;

class EventoType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder    
            ->add('nombre', TextType::class)
            ->add('fecha_inicio', DateTimeType::class)
            ->add('fecha_fin', DateTimeType::class)
            ->add('descripcion', TextareaType::class)
            ->add('idCategoria', CategoriaTipoType::class)
            ->add('idUser', UserTipoType::class)
            ->add('btnEnviar', SubmitType::class, ["label"=>"Guardar"]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([ 'data_class' => Evento::class, ]);
    }

}

?>