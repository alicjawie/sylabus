<?php

namespace AppBundle\Form;

use AppBundle\Entity\CourseContent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseContentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'required' => true,
                'label' => 'TITLE'
            ))
            ->add('author', TextType::class, array(
                'required' => true,
                'label' => 'AUTHOR'
            ))
            ->add('description', TextareaType::class, array(
                'attr'=> array('class' => 'ckEditor'),
                'required' => true,
                'empty_data' => ' ',
                'label' => 'DESCRIPTION'
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => CourseContent::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_bundle_course_content';
    }
}
