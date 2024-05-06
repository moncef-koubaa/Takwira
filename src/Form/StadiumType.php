<?php

namespace App\Form;

use App\Entity\Stadium;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\File;






class StadiumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('name')
            ->add('pricePerHour', IntegerType::class)
            ->add('city', ChoiceType::class, [
                'choices' => Stadium::$citiesAndValues,
            ])
            ->add('zipCode')
            ->add('address')
            ->add('hasShower')
            ->add('hasPark')
            ->add('stadiumImages', FileType::class, [
                'mapped' => false,
                'multiple' => true,
                'required' => false,
                'attr' => [
                    'accept' => 'image/*',
                    'class' => 'upload'
                ],
                'constraints' => [
                    new All([
                        new File([
                            'maxSize' => '5M',
                            'mimeTypes' => [
                                'image/*'
                            ],
                            'mimeTypesMessage' => 'Please upload a valid image file',
                        ])

                    ])
                ]
            ])
            ->add('addStadium', SubmitType::class)
            ->add('ownerId')
            ->add('owner', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stadium::class,
        ]);
    }
}
