<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use App\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Nombre', 'class' => 'form-input']
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Correo electrónico', 'class' => 'form-input']
            ])
            ->add('password', PasswordType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Contraseña', 'class' => 'form-input']
            ])
            ->add('direccion', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Dirección', 'class' => 'form-input']
            ])
            ->add('telefono', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Teléfono', 'class' => 'form-input']
            ])
            ->add('fecha', DateType::class, [
                'label' => false,
                'mapped' =>false,
                'widget' => 'single_text',
                'attr' => ['class' => 'form-input']
            ])
            ->add('siguiente', SubmitType::class, [
                'label' => 'Siguiente',
                'attr' => ['class' => 'btn btn-success form-button']
            ])
            ->add('cancelar', ButtonType::class, ['label' => 'Cancelar', 'attr' => ['onclick' => 'history.back()', 'class' => 'btn btn-gris form-button']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
        ]);
    }
}