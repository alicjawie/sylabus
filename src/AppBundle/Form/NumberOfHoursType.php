<?php

namespace AppBundle\Form;

use AppBundle\Entity\NumberOfHours;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NumberOfHoursType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lecture', NumberType::class, array(
                'label' => 'LECTURE'
            ))
            ->add('exercises', NumberType::class, array(
                'label' => 'EXERCISES'
            ))
            ->add('laboratories', NumberType::class, array(
                'label' => 'LABORATORIES'
            ))
            ->add('exercisesLaboratories', NumberType::class, array(
                'label' => 'EXERCISES_LABORATORIES'
            ))
            ->add('ownWork', NumberType::class, array(
                'label' => 'OWN_WORK'
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => NumberOfHours::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_bundle_number_of_hours';
    }
}
