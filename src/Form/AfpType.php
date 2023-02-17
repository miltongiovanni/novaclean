<?php

namespace App\Form;

use App\Entity\Afp;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AfpType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('contacto')
            ->add('telefono')
            ->add('extension')
            ->add('celular')
            ->add('fecha_creacion')
            ->add('fecha_actualizacion')
            ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Afp::class,
        ]);
    }
}
