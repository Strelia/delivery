<?php

namespace App\Form;

use App\Entity\Business;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Password'
            ])
            ->add('email', EmailType::class)
            ->add('name')
            ->add('surname')
            ->add('phone', TelType::class)
            ->add('occupations', ChoiceType::class, [
                'choices' => array_combine(Business::OCCUPATIONS_CHOICE, Business::OCCUPATIONS_CHOICE),
                'required' => true,
                'multiple' => true,
                'mapped' => false
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'validation_groups' =>  ['set-password', 'Default']
        ]);
    }
}
