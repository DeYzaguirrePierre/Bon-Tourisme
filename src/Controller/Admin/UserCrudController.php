<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
            EmailField::new('email', 'Email')->setRequired(true),
            ArrayField::new('roles', 'Rôles')->setRequired(true),
            TextField::new('password', 'Mot de passe')->setRequired(true),
            BooleanField::new('isVerified', 'Vérifié')->setFormTypeOption('disabled', true),

            // Affiche uniquement le nombre d'avis dynamique
            IntegerField::new('nbAvis', 'Nombre d\'avis')
                ->setFormTypeOption('disabled', true)
                ->formatValue(fn($value, $entity) => $entity->getNbAvis()),
        ];

        return $fields;
    }
}
