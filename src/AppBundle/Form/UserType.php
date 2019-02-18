<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array(
        'label' => 'USERNAME'
    ))
            ->add('name', TextType::class, array(
        'label' => 'NAME2'
    ))
            ->add('surname', TextType::class, array(
        'label' => 'SURNAME'
    ))
            ->add('index', TextType::class, array(
        'label' => 'INDEX'
    ))
            ->add('email', TextType::class, array(
        'label' => 'EMAIL'
    ))
    ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_bundle_user';
    }
}
