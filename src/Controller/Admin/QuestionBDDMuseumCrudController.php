<?php

namespace App\Controller\Admin;

use App\Entity\QuestionBDDMuseum;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class QuestionBDDMuseumCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return QuestionBDDMuseum::class;
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
