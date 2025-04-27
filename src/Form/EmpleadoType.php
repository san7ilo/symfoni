<?php

namespace App\Form;

use App\Entity\Empleado;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmpleadoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Nombre',
                'attr' => ['class' => 'form-control'],
                'required' => true,
            ])
            ->add('lastname', null, [
                'label' => 'Apellido',
                'attr' => ['class' => 'form-control'],
                'required' => true,
            ])
            ->add('email', null, [
                'label' => 'Correo Electrónico',
                'attr' => ['class' => 'form-control'],
                'required' => true,
            ])
            ->add('phone', null, [
                'label' => 'Teléfono',
                'attr' => ['class' => 'form-control'],
                'required' => true,
            ])
            ->add('birthdate', null, [
                'label' => 'Fecha de Nacimiento',
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
                'required' => true,
            ])
            ->add('salary', null, [
                'label' => 'Salario',
                'attr' => ['class' => 'form-control'],
                'required' => true,
            ])
            ->add('contractdate', null, [
                'label' => 'Fecha de Contrato',
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
                'required' => true,
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Estado',
                'required' => true,
                'attr' => ['class' => 'form-select'],
                'choices' => [
                    'Activo' => true,
                    'Inactivo' => false,
                ],
                'expanded' => false,
                'multiple' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Empleado::class,
        ]);
    }
}
