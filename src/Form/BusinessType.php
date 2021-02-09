<?php

namespace App\Form;

use App\Entity\Business;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BusinessType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('internationalName')
            ->add('brand')
            ->add('address')
            ->add('webURL', UrlType::class)
            ->add('logo', FileType::class, [
                'mapped' => false,
            ])
            ->add('occupations', ChoiceType::class, [
                'choices' => array_combine(Business::OCCUPATIONS_CHOICE, Business::OCCUPATIONS_CHOICE),
                'required' => true,
                'multiple' => true
            ])
            ->add('agencyType', ChoiceType::class, [
                'choices' => array_combine(Business::AGENCY_TYPE_CHOICE, Business::AGENCY_TYPE_CHOICE),
                'require' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Business::class,
        ]);
    }
}
