<?php

namespace App\Form;

use App\Entity\Reservation;
use App\Entity\Vol;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $builder
            ->add('dateReservation', DateTimeType::class, [
                'widget' => 'single_text',
                'attr'=>['class'=>"picker form-control"]
            ,'required'=>false])
            
            ->add('nbr', IntegerType::class,['attr'=>['class'=>"form-control"],'required'=>false])
            
            
        ;
        
        if($options["admin"]){
            $builder
            ->add('iduser', IntegerType::class,['attr'=>['class'=>"form-control"],'required'=>false])
        ->add('vol',EntityType::class,['class'=>Vol::class,'attr'=>['class'=>"form-control"],'required'=>false])
        //->add('volgeneriqueId', IntegerType::class,['attr'=>['class'=>"from-control"]])
        ;}
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
            'admin'=>array(),
            
        ]);
    }
}
