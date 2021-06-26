<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('numtel')
            ->add('email')
            ->add('adresse')
            ->add('reservation', EntityType::class, [
                // looks for choices from this entity
                'class' => Reservation::class,
            
                // uses the User.username property as the visible option string
                'choice_label' => 'id',
            
                // used to render a select box, check boxes or radios
                'multiple' => true,
                // 'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
