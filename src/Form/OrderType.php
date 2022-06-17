<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Carrier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // user params send from the controller is accessible in $option
        $user = $options['user'];
        $builder
            ->add('addresses', EntityType::class, [
                'label' => "Choississez votre adresse de livraison",
                'required' => true,
                'class' => Address::class,
                'choices' => $user->getAddresses(),
                'multiple' => false,
                'expanded' => true
             ])

            ->add('carriers', EntityType::class, [
                'label' => "Choississez votre transporteur",
                'required' => true,
                'class' => Carrier::class,
                'multiple' => false,
                'expanded' => true
             ])
             ->add('submit', SubmitType::class, [
                'label' => "Valider ma commande"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'user' => array()
        ]);
    }
}
 