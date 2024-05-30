<?php

namespace App\Form;

use App\Entity\Comercios;
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
            ->add('nombreComercio', TextType::class, [
                'attr' => ['class' => 'form-field'],
                'label_attr' => ['class' => 'campo-etiqueta']
            ])
            ->add('CIF', TextType::class, [
                'attr' => ['class' => 'form-field'],
                'label_attr' => ['class' => 'campo-etiqueta']
            ])
            ->add('direccionComercio', TextType::class, [
                'attr' => ['class' => 'form-field'],
                'label_attr' => ['class' => 'campo-etiqueta']
            ])
            ->add('telefono', TextType::class, [
                'attr' => ['class' => 'form-field'],
                'label_attr' => ['class' => 'campo-etiqueta']
            ])
            ->add('razonSocial', TextType::class, [
                'attr' => ['class' => 'form-field'],
                'label_attr' => ['class' => 'campo-etiqueta']
            ])
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'form-field'],
                'label_attr' => ['class' => 'campo-etiqueta']
            ])
            ->add('codigoPostal', TextType::class, [
                'attr' => ['class' => 'form-field'],
                'label_attr' => ['class' => 'campo-etiqueta']
            ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comercios::class,
        ]);
    }
}