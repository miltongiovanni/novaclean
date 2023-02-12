<?php

namespace App\Form;

use App\Entity\Personal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('identificacion')
            ->add('lugar_expedicion')
            ->add('nombre')
            ->add('apellido')
            ->add('numero_cuenta')
            ->add('salario_basico')
            ->add('bono')
            ->add('direccion')
            ->add('telefono')
            ->add('correo_electronico')
            ->add('celular')
            ->add('f_nacimiento')
            ->add('f_ingreso')
            ->add('f_examen_ingreso')
            ->add('sexo')
            ->add('tipo_nomina')
            ->add('afp')
            ->add('eps')
            ->add('afc')
            ->add('tipo_cuenta')
            ->add('talla_uniforme')
            ->add('talla_botas')
            ->add('cargo')
            ->add('talla_guantes')
            ->add('curso_especializado')
            ->add('talla_camisa')
            ->add('talla_pantalon')
            ->add('talla_calzado')
            ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personal::class,
        ]);
    }
}
