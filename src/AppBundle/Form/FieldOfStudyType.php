<?php

namespace AppBundle\Form;

use AppBundle\Entity\Degree;
use AppBundle\Entity\FieldOfStudy;
use AppBundle\Entity\Year;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FieldOfStudyType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'NAME'
            ))
            ->add('mode', ChoiceType::class, array(
                'choices' => FieldOfStudy::$SUPPORTED_MODES,
                'label' => 'MODE',
                'choice_translation_domain' => true,
            ))
            ->add('degree', EntityType::class, array(
                'class' => Degree::class,
                'label' => 'DEGREE'
            ))
            ->add('year', EntityType::class, array(
                'class' => Year::class,
                'label' => 'YEAR'
            ))
            ->add('language', TextType::class, array(
                'label' =>'LANGUAGE'
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => FieldOfStudy::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_bundle_field_of_study';
    }
}
