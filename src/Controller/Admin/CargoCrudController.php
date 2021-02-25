<?php

namespace App\Controller\Admin;

use App\Entity\Cargo;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use JetBrains\PhpStorm\Pure;

class CargoCrudController extends AbstractCrudController
{
    private array $statusChoice;
    private array $prepaymentType;
    private array $paymentType;

    /**
     * CargoCrudController constructor.
     */
    public function __construct()
    {
        $this->statusChoice = array_combine(Cargo::STATUS_CHOICE, Cargo::STATUS_CHOICE);
        $this->prepaymentType = array_combine(Cargo::PREPAYMENT_TYPE_CHOICE, Cargo::PREPAYMENT_TYPE_CHOICE);
        $this->paymentType = array_combine(Cargo::PAYMENT_TYPE_CHOICE, Cargo::PAYMENT_TYPE_CHOICE);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
//            ->add(Crud::PAGE_EDIT, Action::SAVE_AND_ADD_ANOTHER)
            ;
    }


    public static function getEntityFqcn(): string
    {
        return Cargo::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name');
        yield AssociationField::new('owner');
        yield IntegerField::new('weight');
        yield IntegerField::new('volume');
        yield IntegerField::new('length')->hideOnIndex();
        yield IntegerField::new('width')->hideOnIndex();
        yield IntegerField::new('diameter')->hideOnIndex();
        yield IntegerField::new('countBelt')->hideOnIndex();
        yield TextField::new('addressFrom');
        yield TextField::new('addressTo');
        yield AssociationField::new('adr')->hideOnIndex();
        yield AssociationField::new('carBodies')->hideOnIndex();
        yield BooleanField::new('hasHitch')->hideOnIndex();
        yield BooleanField::new('hasRuberTyres')->hideOnIndex();
        yield BooleanField::new('hasHook')->hideOnIndex();
        yield BooleanField::new('isTir')->hideOnIndex();
        yield BooleanField::new('isCMR', 'Is CMR')->hideOnIndex();
        yield BooleanField::new('isT1')->hideOnIndex();
        yield DateField::new('dateStartMin');
        yield DateField::new('dateStartMax');
        yield IntegerField::new('price');
        yield ChoiceField::new('paymentKind')
            ->setChoices($this->paymentType)->hideOnIndex();
        yield BooleanField::new('isVat')->hideOnIndex();
        yield ChoiceField::new('prepaymentKind')
            ->setChoices($this->prepaymentType)->hideOnIndex();
        yield IntegerField::new('prepayment')->hideOnIndex();
        yield BooleanField::new('isHiddenUserRequest')->hideOnIndex();
        yield ChoiceField::new('status')
            ->setChoices($this->statusChoice);
        yield AssociationField::new('loadingKinds')->hideOnIndex();
        yield AssociationField::new('unloadingKinds')->hideOnIndex();
        yield AssociationField::new('packagingKind')->hideOnIndex();
    }

}
