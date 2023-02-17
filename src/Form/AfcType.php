<?php

namespace App\Form;

use App\Entity\Afc;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AfcType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('contacto')
            ->add('telefono')
            ->add('extension')
            ->add('fecha_creation')
            ->add('fecha_actualizacion')
            ->add('celular')
            ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Afc::class,
        ]);
    }
}
