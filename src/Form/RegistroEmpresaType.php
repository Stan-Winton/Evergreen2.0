<?php

namespace App\Form;

use App\Entity\Comercios;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistroEmpresaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombreComercio', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Nombre del comercio', 'class' => 'form-input']
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Correo electrónico', 'class' => 'form-input']
            ])
            ->add('password', PasswordType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Contraseña', 'class' => 'form-input']
            ])
            ->add('CIF', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'CIF', 'class' => 'form-input']
            ])
            ->add('descripcion', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Descripción', 'class' => 'form-input']
            ])
            ->add('direccionComercio', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Dirección del comercio', 'class' => 'form-input']
            ])
            ->add('telefono', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Teléfono', 'class' => 'form-input']
            ])
            ->add('razonSocial', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Razón social', 'class' => 'form-input']
            ])
            ->add('codigoPostal', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Código postal', 'class' => 'form-input']
            ])
            ->add('siguiente', SubmitType::class, [
                'label' => 'Siguiente',
                'attr' => ['class' => 'btn btn-success form-button']
            ])
            ->add('cancelar', ButtonType::class, ['label' => 'Cancelar', 'attr' => ['onclick' => 'history.back()', 'class' => 'btn btn-gray form-button']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comercios::class,
        ]);
    }
}