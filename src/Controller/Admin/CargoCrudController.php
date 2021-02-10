<?php

namespace App\Controller\Admin;

use App\Entity\Cargo;
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
        yield IntegerField::new('length');
        yield IntegerField::new('width');
        yield IntegerField::new('diameter');
        yield IntegerField::new('countBelt');
        yield TextField::new('addressFrom');
        yield TextField::new('addressTo');
        yield AssociationField::new('adr');
        yield AssociationField::new('carBodies');
        yield BooleanField::new('hasHitch');
        yield BooleanField::new('hasRuberTyres');
        yield BooleanField::new('hasHook');
        yield BooleanField::new('isTir');
        yield BooleanField::new('isCMR', 'Is CMR');
        yield BooleanField::new('isT1');
        yield IntegerField::new('countCars');
        yield DateField::new('dateStartMin');
        yield DateField::new('dateStartMax');
        yield IntegerField::new('price');
        yield ChoiceField::new('paymentKind')
            ->setChoices($this->paymentType);
        yield BooleanField::new('isVat');
        yield ChoiceField::new('prepaymentKind')
            ->setChoices($this->prepaymentType);
        yield IntegerField::new('prepayment');
        yield BooleanField::new('isHiddenUserRequest');
        yield ChoiceField::new('status')
            ->setChoices($this->statusChoice);
        yield AssociationField::new('loadingKinds');
        yield AssociationField::new('unloadingKinds');
        yield AssociationField::new('packagingKind');
    }

}
