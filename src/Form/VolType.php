<?php

namespace App\Form;

use App\Entity\Vol;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
class VolType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateArrivee', DateTimeType::class,['widget' => 'single_text','attr'=>['class'=>"form-control picker"],'required'=>false])
            ->add('dateDepart', DateTimeType::class,['widget' => 'single_text','attr'=>['class'=>"form-control picker"],'required'=>false])
            ->add('lieuArrive', TextType::class,['attr'=>['class'=>"form-control"],'required'=>false])
            ->add('lieuDepart', TextType::class,['attr'=>['class'=>"form-control"],'required'=>false])
            ->add('montant', NumberType::class,['attr'=>['class'=>"form-control"],'required'=>false])
            ->add('nbrdispo', IntegerType::class,['attr'=>['class'=>"form-control"],'required'=>false])
            ->add('imageFile',FileType::class,['attr'=>['class'=>"form-control picker"],'required'=>false])
          //  ->add('factureId', IntegerType::class,['attr'=>['class'=>"form-control"]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vol::class,
        ]);
    }
}
