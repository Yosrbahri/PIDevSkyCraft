<?php

namespace App\Form;

use App\Entity\Facture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class FactureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('designation', NumberType::class,['attr'=>['class'=>"form-control"]])
            ->add('nbr', NumberType::class,['attr'=>['class'=>"form-control"]])
            ->add('prixTotal', NumberType::class,['attr'=>['class'=>"form-control"]])
            ->add('prixUnitaire', NumberType::class,['attr'=>['class'=>"form-control"]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Facture::class,
        ]);
    }
}
