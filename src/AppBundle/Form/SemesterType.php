<?php

namespace AppBundle\Form;

use AppBundle\Entity\FieldOfStudy;
use AppBundle\Entity\Semester;
use AppBundle\Entity\Subject;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SemesterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('yearOfStudy', TextType::class, array (
                'label' => 'YEAROFSTUDY'
            ))
            ->add('type', ChoiceType::class, array(
                'choices' => Semester::$SUPPORTED_TYPES,
                    'label' => 'TYPE'
            ))
            ->add('fieldOfStudy', EntityType::class, array(
                'class' => FieldOfStudy::class,
                'label' => 'FIELD_OF_STUDY2'
            ))
            ->add('subjects', EntityType::class, array(
                'multiple' => true,
                'class' => Subject::class,
                'label' => 'SUBJECT'
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Semester::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_semester';
    }
}
