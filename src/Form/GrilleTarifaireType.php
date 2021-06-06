<?php

namespace App\Form;
use App\Entity\Offre;

use App\Entity\GrilleTarifaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use App\Entity\Hotel;

class GrilleTarifaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date_debut')
            ->add('date_fin')
            ->add('description')
            ->add('prix')
            ->add(
                'hotelgrille',
                EntityType::class,
                [
                    'class' => Hotel::class,
                    'choice_label' => 'nom',
                    'required' => true,
                    'multiple' => true,
                ]
             )
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GrilleTarifaire::class,
        ]);
    }
}
