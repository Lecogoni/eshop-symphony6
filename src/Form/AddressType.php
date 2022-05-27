<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Quel nom souhaitez vous donner à cette addresse ?', 
                'attr' => [
                    'label' => 'nom de cette addresse'
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Quel est votre prénom ?', 
                'attr' => [
                    'label' => 'votre prénom'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Quel est votre nom ?', 
                'attr' => [
                    'label' => 'votre nom'
                ]
            ])
            ->add('company', TextType::class, [
                'label' => 'Nom de votre société ? (facultatif)',
                'required' => false,
                'attr' => [
                    'label' => 'entrer le nom de votre société'
                ]
            ])
            ->add('address', TextType::class, [
                'label' => 'Quel est votre addresse ?', 
                'attr' => [
                    'label' => 'votre addresse'
                ]
            ])
            ->add('postal', TextType::class, [
                'label' => 'Votre code postal ?', 
                'attr' => [
                    'label' => 'votre code postal'
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'Votre ville ?', 
                'attr' => [
                    'label' => 'Votre ville'
                ]
            ])
            ->add('country', CountryType::class, [
                'label' => 'Votre pays ?', 
                'attr' => [
                    'label' => 'Votre pays'
                ]
            ])
            ->add('phone', TelType::class, [
                'label' => 'Entrez votre numéro de téléphone ?', 
                'attr' => [
                    'label' => 'votre numéro de téléphone'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'valider'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
