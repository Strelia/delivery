<?php

namespace App\Controller\Admin;

use App\Admin\Filter\ChoiceJSONBFilter;
use App\Entity\Business;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;

class BusinessCrudController extends AbstractCrudController
{
    protected array $statusChoice;
    protected array $occupationsChoice;
    protected array $agencyTypeChoice;

    /**
     * BusinessCrudController constructor.
     */
    public function __construct()
    {
        $this->statusChoice = array_combine(Business::STATUS_CHOICE, Business::STATUS_CHOICE);
        $this->occupationsChoice = array_combine(Business::OCCUPATIONS_CHOICE,Business::OCCUPATIONS_CHOICE);
        $this->agencyTypeChoice = array_combine(Business::AGENCY_TYPE_CHOICE, Business::AGENCY_TYPE_CHOICE);
    }

    public static function getEntityFqcn(): string
    {
        return Business::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        $filters
            ->add(
                ChoiceFilter::new('status')
                    ->setChoices($this->statusChoice)
            )
            ->add(
                ChoiceJSONBFilter::new('occupations')
                    ->setChoices($this->occupationsChoice)
            )
            ->add(
                ChoiceFilter::new('agencyType')
                    ->setChoices($this->agencyTypeChoice)
            )
        ;
        return parent::configureFilters($filters);
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name')->setRequired(true);
        yield TextField::new('internationalName');
        yield TextField::new('brand');
        yield TextField::new('address')->setRequired(true);
        yield UrlField::new('webURL', 'URL');
        yield ImageField::new('logo')
            ->setBasePath('images/')
            ->setUploadDir('public/images')
        ;
        yield ChoiceField::new('status')->setChoices($this->statusChoice);
        yield ChoiceField::new('occupations')->setRequired(true)
            ->allowMultipleChoices()->setChoices($this->occupationsChoice);
        yield ChoiceField::new('agencyType')->setRequired(true)->setChoices($this->agencyTypeChoice);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Businesses')
            ->setEntityLabelInPlural('Businesses')
            ->setSearchFields(['id', 'name', 'internationalName', 'address', 'webURL']);
    }
}
