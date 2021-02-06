<?php

namespace App\Controller\Admin;

use App\Entity\PackagingKind;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class PackagingKindCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PackagingKind::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name');
        yield AssociationField::new('parent');
    }

    public function configureFilters(Filters $filters): Filters
    {
        $filters
            ->add(EntityFilter::new('parent'));
        return parent::configureFilters($filters);
    }

}
