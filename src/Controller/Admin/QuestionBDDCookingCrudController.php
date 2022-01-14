<?php

namespace App\Controller\Admin;

use App\Entity\QuestionBDDCooking;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class QuestionBDDCookingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return QuestionBDDCooking::class;
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
