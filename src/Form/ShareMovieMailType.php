<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ShareMovieMailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // use Symfony\Component\Form\Extension\Core\Type\EmailType;
            ->add('dest', EmailType::class)
            // use Symfony\Component\Form\Extension\Core\Type\TextType;
            ->add('object', TextType::class)
            // use Symfony\Component\Form\Extension\Core\Type\TextareaType;
            ->add('message', TextareaType::class)
            // use Symfony\Component\Form\Extension\Core\Type\SubmitType;
            ->add('send', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
