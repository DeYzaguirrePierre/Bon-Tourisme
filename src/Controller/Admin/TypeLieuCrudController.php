<?php

namespace App\Controller\Admin;

use App\Entity\TypeLieu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TypeLieuCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TypeLieu::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('type')
                ->setLabel('Type de lieu')
                ->setRequired(true)
        ];
    }
}
