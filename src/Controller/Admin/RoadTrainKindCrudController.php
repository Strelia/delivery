<?php

namespace App\Controller\Admin;

use App\Entity\RoadTrainKind;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RoadTrainKindCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return RoadTrainKind::class;
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
