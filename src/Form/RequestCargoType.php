<?php

namespace App\Form;

use App\Entity\RequestCargo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RequestCargoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('status')
            ->add('price')
            ->add('weight')
            ->add('volume')
            ->add('note')
            ->add('cargo')
            ->add('executor')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RequestCargo::class,
        ]);
    }
}
