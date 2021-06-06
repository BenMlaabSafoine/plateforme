<?php

namespace App\Form;

use App\Entity\AgenceVoyage;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class AgenceVoyageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            
            ->add('description')
            ->add('numtel')
            ->add('email')
            ->add('adresse')
            ->add('Agents', EntityType::class, [
                // looks for choices from this entity
                'class' => User::class,
            
                // uses the User.username property as the visible option string
                'choice_label' => 'username',
            
                // used to render a select box, check boxes or radios
                 'multiple' => true,
                // 'expanded' => true,
            ]);
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AgenceVoyage::class,
        ]);
    }
}
