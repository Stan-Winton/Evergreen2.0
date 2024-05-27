<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class Login2FormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipo_usuario', ChoiceType::class, [
                'choices'  => [
                    'Particular' => 'particular',
                    'Empresa' => 'empresa',
                ],
                'expanded' => true,
            ])
            ->add('save', SubmitType::class, ['label' => 'Siguiente'])
        ;
    }
}