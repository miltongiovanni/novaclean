<?php

namespace App\Form;

use App\Entity\Contrato;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContratoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('n_contrato')
            ->add('f_inicio')
            ->add('f_fin')
            ->add('poliza_salario')
            ->add('poliza_cumplimiento')
            ->add('n_poliza')
            ->add('aseguradora')
            ->add('vencimiento_poliza')
            ->add('observaciones')
            ->add('user')
            ->add('cliente')
            ->add('personal')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contrato::class,
        ]);
    }
}
