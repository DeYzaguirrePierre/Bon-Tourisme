<?php

namespace App\Controller\Admin;

use App\Entity\Lieu;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class LieuCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Lieu::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $tabLieu = [
            TextField::new('nom', 'Nom')
                ->setRequired(true)
        ];

        $image =
            ImageField::new('image', 'Image')
            ->setBasePath('uploads')
            ->setUploadDir('public/uploads')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setRequired(false);

        $desc = TextField::new('description', 'Description')
            ->setRequired(true);

        $type =
            AssociationField::new('type_lieu', 'Types de lieu')
            ->setFormTypeOption('by_reference', false) // nécessaire pour ManyToMany
            ->autocomplete()
            ->setRequired(true)
            ->formatValue(function ($value, $entity) {
                // Récupère tous les noms des types de lieu associés et les transforme en chaîne
                return implode(', ', $entity->getTypeLieu()->map(fn($typeLieu) => $typeLieu->getType())->toArray());
            });

        $moyAvis = IntegerField::new('moy_avis', 'Moyenne des avis')
            ->setFormTypeOption('disabled', true);
        $nbAvis = IntegerField::new('nb_avis', 'Nombre d\'avis')
            ->setFormTypeOption('disabled', true);;

        $tabLieu[] = $image;
        $tabLieu[] = $desc;
        $tabLieu[] = $type;
        $tabLieu[] = $moyAvis;
        $tabLieu[] = $nbAvis;
        return $tabLieu;
    }
}
