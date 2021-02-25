<?php

namespace App\Form;

use App\Entity\Adr;
use App\Entity\CarBodyKind;
use App\Entity\Cargo;
use App\Entity\LoadingKind;
use App\Entity\PackagingKind;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CargoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('weight', NumberType::class)
            ->add('volume', NumberType::class, [
                'required' => false
            ])
            ->add('length', NumberType::class, [
                'required' => false
            ])
            ->add('width', NumberType::class, [
                'required' => false
            ])
            ->add('diameter', NumberType::class, [
                'required' => false
            ])
            ->add('countBelt', NumberType::class, [
                'required' => false
            ])
            ->add('addressFrom')
            ->add('addressTo')
            ->add('hasHitch', CheckboxType::class, [
                'required' => false
            ])
            ->add('hasRuberTyres', CheckboxType::class, [
                'required' => false
            ])
            ->add('hasHook', CheckboxType::class, [
                'required' => false
            ])
            ->add('isTir', CheckboxType::class, [
                'required' => false
            ])
            ->add('isCMR', CheckboxType::class, [
                'label' => 'Is CMR',
                'required' => false
            ])
            ->add('isT1', CheckboxType::class, [
                'required' => false
            ])
            ->add('dateStartMin', DateType::class, [
                'widget' => 'choice',
                'input'  => 'datetime_immutable'
            ])
            ->add('dateStartMax', DateType::class, [
                'widget' => 'choice',
                'input'  => 'datetime_immutable'
            ])
            ->add('price', NumberType::class)
            ->add('paymentKind', ChoiceType::class, [
                'label' => 'Payment Kind',
                'choices' => array_combine(Cargo::PAYMENT_TYPE_CHOICE, Cargo::PAYMENT_TYPE_CHOICE)
            ])
            ->add('isVat', CheckboxType::class, [
                'required' => false
            ])
            ->add('prepayment', NumberType::class, [
                'required' => false
            ])
            ->add('isHiddenUserRequest', CheckboxType::class, [
                'required' => false
            ])
            ->add('adr', EntityType::class, [
                'class' => Adr::class,
                'choice_label' => 'name',
                'required' => false
            ])
            ->add('carBodies', EntityType::class, [
                'class' => CarBodyKind::class,
                'multiple'  => true,
                'choice_label' => 'name',
                'required' => false
            ])
            ->add('loadingKinds', EntityType::class, [
                'class' => LoadingKind::class,
                'multiple'  => true,
                'choice_label' => 'name',
                'required' => false
            ])
            ->add('unloadingKinds', EntityType::class, [
                'class' => LoadingKind::class,
                'multiple'  => true,
                'choice_label' => 'name',
                'required' => false
            ])
            ->add('packagingKind', EntityType::class, [
                'class' => PackagingKind::class,
                'choice_label' => 'name',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cargo::class,
        ]);
    }
}
