<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class PostType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('title', TextType::class, ['label' => 'Tytuł', 'attr' => array(
            'placeholder' => 'Tytuł artykułu')])
        ->add('heading', TextareaType::class, ['label' => 'Nagłówek', 'attr' => array(
            'placeholder' => 'Nagłówek')])
        ->add('content', TextareaType::class, ['label' => 'Tekst artykułu', 'attr' => array(
            'rows' => 12)])
        ->add('Gotowe', SubmitType::class, ['attr' => array(
            'class' => 'btn btn-primary')])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Post'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_post';
    }


}
