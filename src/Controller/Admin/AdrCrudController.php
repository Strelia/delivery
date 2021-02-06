<?php

namespace App\Controller\Admin;

use App\Entity\Adr;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AdrCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Adr::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
