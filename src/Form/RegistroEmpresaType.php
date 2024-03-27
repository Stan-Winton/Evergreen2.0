<?php

namespace App\Form;

use App\Entity\Comercios;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

class RegistroEmpresaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombreComercio')
            ->add('email')
            ->add('password')
            ->add('CIF')
            ->add('descripcion')
            ->add('direccionComercio')
            ->add('telefono')
            ->add('razonSocial')
            ->add('siguiente', SubmitType::class, ['label' => 'Siguiente'])
            ->add('cancelar', ButtonType::class, ['label' => 'Cancelar', 'attr' => ['onclick' => 'history.back()']]);
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comercios::class,
        ]);
    }
}
