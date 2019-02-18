<?php

namespace AppBundle\Form;

use AppBundle\Entity\Subject;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubjectType extends AbstractType
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
            ->add('code', TextType::class, array(
                'label' => 'CODE'
            ))
            ->add('lecturer', TextType::class, array(
                'label' => 'LECTURER'
            ))
            ->add('description', TextareaType::class, array(
                'attr'=> array('class' => 'ckEditor'),
                'label' => 'DESCRIPTION'
            ))
            ->add('numberOfHours', NumberOfHoursType::class, array(
                'label' => 'CODE'
            ))
            ->add('additionalField', AdditionalFieldType::class, array(
                'label' => 'CODE'
            ))
            ->add('extraFields', CollectionType::class, array(
                'entry_type' => ExtraFieldType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'entry_options'  => array(
                    'attr'      => array('class' => 'extra-field')),
                    'label' => 'COURSE_CONTENT'
            ))
            ->add('courseContents', CollectionType::class, array(
                'entry_type' => CourseContentType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'entry_options'  => array(
                    'attr'      => array('class' => 'course-content')),
                'label' => 'LITERATURE'
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Subject::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_bundle_subject';
    }
}
