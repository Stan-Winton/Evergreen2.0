<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComercioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre_comercio', TextType::class)
            ->add('cif', TextType::class)
            ->add('direccion_comercio', TextType::class)
            ->add('telefono', TextType::class)
            ->add('razon_social', TextType::class)
            ->add('email', EmailType::class)
            ->add('codigo_postal', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configura aquí las opciones
        ]);
    }
}