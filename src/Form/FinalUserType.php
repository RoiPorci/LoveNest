<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FinalUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('birth_date', DateType::class, [
                'label' => 'Date de naissance',
                'required' => false
            ])
            ->add('gender', TextType::class, [
                'label' => 'Genre',
                'required' => false
            ])
            ->add('zip_code', TextType::class, [
                'label' => 'Code postal',
                'required' => false
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville actuelle',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'validation_groups' => [
                User::class,
                'completeRegistration'
            ]
        ]);
    }
}
