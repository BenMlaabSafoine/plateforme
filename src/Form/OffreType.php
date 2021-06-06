<?php

namespace App\Form;

use App\Entity\Offre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Pays;
use App\Entity\Hotel;
use App\Entity\AgenceVoyage;
use App\Entity\GrilleTarifaire;

class OffreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('agencevoyage',
        EntityType::class,
        [
            'class' => AgenceVoyage::class,
            'choice_label' => 'nom',
            'required' => true,
            'multiple' => false,
        ]
     )
            ->add('pays',
                EntityType::class,
                [
                    'class' => Pays::class,
                    'choice_label' => 'nom',
                    'required' => true,
                    'multiple' => true,
                ]
             )
             ->add(
                'hotels',
                EntityType::class,
                [
                    'class' => Hotel::class,
                    'choice_label' => 'nom',
                    'required' => true,
                    'multiple' => true,
                ]
             )
             ->add('grilletarifaires',
             EntityType::class,
             [
                 'class' => GrilleTarifaire::class,
                 'choice_label' => 'description',
                 'required' => true,
                 'multiple' => true,
             ]
          )
             
             ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Offre::class,
        ]);
    }
}
