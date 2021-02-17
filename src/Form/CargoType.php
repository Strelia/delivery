<?php

namespace App\Form;

use App\Entity\Cargo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CargoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('weight')
            ->add('volume')
            ->add('length')
            ->add('width')
            ->add('diameter')
            ->add('countBelt')
            ->add('addressFrom')
            ->add('addressTo')
            ->add('hasHitch')
            ->add('hasRuberTyres')
            ->add('hasHook')
            ->add('isTir')
            ->add('isCMR')
            ->add('isT1')
            ->add('countCars')
            ->add('dateStartMin')
            ->add('dateStartMax')
            ->add('price')
            ->add('paymentKind')
            ->add('isVat')
            ->add('prepaymentKind')
            ->add('prepayment')
            ->add('isHiddenUserRequest')
            ->add('status')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('owner')
            ->add('adr')
            ->add('carBodies')
            ->add('loadingKinds')
            ->add('unloadingKinds')
            ->add('packagingKind')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cargo::class,
        ]);
    }
}
