<?php

namespace App\Form;

use App\Classe\Search;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;


# form créer à la main sans la console qu'on lie à la class Search

class SearchType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('string', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'votre recherche ...',
                    'class' => 'form-control-sm'
                ]
             ])
             ->add('categories', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Category::class,
                'multiple' => true,
                'expanded' => true
             ])
             ->add('submit', SubmitType::class, [
                'label' => "Filter",
                'attr' => [
                    'class' => 'btn btn-primary btn-sm col-12'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    # Si on ne fait rien le form nous retournera un tableau avec les valeurs préfixé avec le nom de la class
    # ici on lui de retourner sans
    public function getBlockPrefix()
    {
        return '';
    }
}