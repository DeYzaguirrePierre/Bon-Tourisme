<?php

namespace App\Controller\Admin;

use App\Entity\TypeLieu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class TypeLieuCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TypeLieu::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('type', 'Type de lieu')->setRequired(true),
            AssociationField::new('lieux', 'Lieux associés')->setFormTypeOption('by_reference', false),
        ];
    }
}
