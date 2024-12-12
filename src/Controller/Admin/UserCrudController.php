<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            //IdField::new('id'),
            EmailField::new('email')
                ->setRequired(true),
            ArrayField::new('roles')
                ->setRequired(true),
            TextField::new('password')
                ->setRequired(true),
            TextField::new('nom')
                ->setRequired(true),
            TextField::new('prenom')
                ->setRequired(true),
            DateField::new('dateNaissance')
                ->setRequired(true),
            IntegerField::new('nb_avis')
                ->setFormTypeOption('disabled', true),

        ];
    }
}
