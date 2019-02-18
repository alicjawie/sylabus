<?php

namespace AppBundle\Form;

use AppBundle\Entity\AdditionalField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdditionalFieldType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ECTS', NumberType::class, array (
                'label' =>  'ECTS',
            ))
            ->add('exam', ChoiceType::class, array(
                'choices' => array(
                    'YES' => true,
                    'NO' => false,
                ),
                    'label' => 'EXAM',

            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => AdditionalField::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_bundle_additional_field';
    }

}
