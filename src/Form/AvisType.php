<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
class AvisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        
        ->add('nom', TextType::class, ['attr' => ['class'=> 'form-control'], 'label_attr' => ['class'=> 'fw-bold']])
        ->add('email', EmailType::class, ['attr' => ['class'=> 'form-control'], 'label_attr' => ['class'=> 'fw-bold']])
        ->add('message', TextareaType::class, ['attr' => ['class'=> 'form-control', 'rows'=>'7', 'cols' => '7'], 'label_attr' => ['class'=> 'fw-bold']])
        ->add('note', RangeType::class, ['attr' => ['min' => 0, 'max' => 5 ], 'label_attr' => ['class'=> 'form-range']])
        ->add('envoyer', SubmitType::class, ['attr' => ['class'=> 'btn bg-light text-primary m-4' ], 'row_attr' => ['class' => 'text-center'],])
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
