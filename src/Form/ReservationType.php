<?php

namespace App\Form;

use App\Entity\Reservation;
use App\Entity\Offre;
use App\Entity\AgenceVoyage;
use App\Entity\Client;
use App\Entity\GrilleTarifaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date')
            
            ->add('offre', EntityType::class, [
                // looks for choices from this entity
                'class' => Offre::class,
            
                // uses the User.username property as the visible option string
                'choice_label' => 'nom',
            
                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
            ])
            ->add('agencevoyage', EntityType::class, [
                // looks for choices from this entity
                'class' => AgenceVoyage::class,
            
                // uses the User.username property as the visible option string
                'choice_label' => 'nom',
            
                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
            ])
             ->add('grilleTarifaire', EntityType::class, [
                // looks for choices from this entity
                'class' => GrilleTarifaire::class,
            
                // uses the User.username property as the visible option string
                'choice_label' => 'description',
            
                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
            ])
            ->add('client', EntityType::class, [
                // looks for choices from this entity
                'class' => Client::class,
            
                // uses the User.username property as the visible option string
                'choice_label' => 'nom',
            
                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
            ])
            ->add('date')
            ->add('statut')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
