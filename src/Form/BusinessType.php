<?php

namespace App\Form;

use App\Entity\Business;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class BusinessType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('internationalName', TextType::class, [
                'label' => 'International Name',
                'required' => false,
            ])
            ->add('brand', TextType::class, [
                'required' => false,
            ])
            ->add('address', TextType::class, [
                'required' => false,
            ])
            ->add('webURL', UrlType::class, [
                'label' => 'URL',
                'required' => false,
            ])
            ->add('logo', FileType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Image(['maxSize' => '1024k'])
                ],
            ])
            ->add('occupations', ChoiceType::class, [
                'choices' => array_combine(Business::OCCUPATIONS_CHOICE, Business::OCCUPATIONS_CHOICE),
                'multiple' => true,
            ])
            ->add('agencyType', ChoiceType::class, [
                'label' => 'Agency Type',
                'choices' => array_combine(Business::AGENCY_TYPE_CHOICE, Business::AGENCY_TYPE_CHOICE),
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
