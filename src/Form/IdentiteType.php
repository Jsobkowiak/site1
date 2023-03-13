<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

use Symfony\Component\Validator\Constraints\File;

class IdentiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('prenom', TextType::class, ['attr' => ['class'=> 'form-control'], 'label_attr' => ['class'=> 'fw-bold']])
        ->add('nom', TextType::class, ['attr' => ['class'=> 'form-control'], 'label_attr' => ['class'=> 'fw-bold']])
        ->add('lieunaissance', TextType::class, ['attr' => ['class'=> 'form-control'], 'label_attr' => ['class'=> 'fw-bold'], 'label' => 'Lieu de naissance'])
        ->add('Ville', TextType::class, ['attr' => ['class'=> 'form-control'], 'label_attr' => ['class'=> 'fw-bold']])
        ->add('Adresse', TextType::class, ['attr' => ['class'=> 'form-control'], 'label_attr' => ['class'=> 'fw-bold']])
        ->add('codepostal', TextType::class, ['attr' => ['class'=> 'form-control'], 'label_attr' => ['class'=> 'fw-bold'], 'label' => 'Code Postal'])
        ->add('date', DateType::class, ['label_attr' => ['class'=> 'fw-bold'], 'label' => 'Date de naissance', 'widget' => 'single_text','format' => 'yyyy-MM-dd',], ['attr' => ['class'=> 'form-control'],])
        ->add('sanscarte', CheckboxType::class,['required' => false,'label_attr' => ['class'=> 'fw-bold'], 'label' => 'Avec vous une ancienne carte d   identité'])
        ->add('fichier', FileType::class, array('mapped' => false,'label' => 'justificatif de domicile',
        'constraints' => [
            new File([
                'maxSize' => '20000k',
                'mimeTypes' => [
                    'application/pdf',
                ],
                'mimeTypesMessage' => 'Le site accepte uniquement les fichiers PDF',
            ])
        ],))
        ->add('fichier2', FileType::class, array('mapped' => false,'label' => 'Ancienne carte d identite','required' =>false,
        'constraints' => [
            new File([
                'maxSize' => '20000k',
                'mimeTypes' => [
                    'application/pdf',
                    'image/jpg',
                ],
                'mimeTypesMessage' => 'Le site accepte uniquement les fichiers PDF, et JPG',
            ])
        ],))
        ->add('envoyer', SubmitType::class, ['attr' => ['class'=> 'btn bg-primary text-light m-4' ], 'row_attr' => ['class' => 'text-center'],])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
