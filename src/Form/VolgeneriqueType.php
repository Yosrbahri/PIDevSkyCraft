<?php

namespace App\Form;

use App\Entity\Volgenerique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class VolgeneriqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('heureDepart', DateTimeType::class,['widget' => 'single_text','attr'=>['class'=>"form-control picker"]])
            ->add('heurearrivee', DateTimeType::class,['widget' => 'single_text','attr'=>['class'=>"form-control picker"]])
            ->add('lieuArrive', TextType::class,['attr'=>['class'=>"form-control"]])
            ->add('lieuDepart', TextType::class,['attr'=>['class'=>"form-control"]])
            ->add('montant', NumberType::class,['attr'=>['class'=>"form-control"]])
            ->add('factureId', IntegerType::class,['attr'=>['class'=>"form-control"]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Volgenerique::class,
        ]);
    }
}
