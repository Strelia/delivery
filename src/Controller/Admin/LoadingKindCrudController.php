<?php

namespace App\Controller\Admin;

use App\Entity\LoadingKind;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class LoadingKindCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return LoadingKind::class;
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
