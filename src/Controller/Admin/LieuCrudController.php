<?php

namespace App\Controller\Admin;

use App\Entity\Lieu;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class LieuCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Lieu::class;
    }

    public function configureFields(string $pageName): iterable
    {
        dump('Formulaire généré');
        return [
            TextField::new('nom', 'Nom')->setRequired(true),
            ImageField::new('image', 'Image')
                ->setBasePath('uploads')
                ->setUploadDir('public/uploads')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            TextField::new('description', 'Description')->setRequired(true),
            AssociationField::new('typeLieux', 'Types de lieu')
                ->setFormTypeOption('by_reference', false) // Gère les relations ManyToMany
                ->setFormTypeOption('choice_label', 'type') // Affiche le champ "type" de TypeLieu
                ->formatValue(function ($value, $entity) {
                    // Affiche les noms des types associés sous forme de chaîne
                    return implode(', ', $entity->getTypeLieux()->map(fn($typeLieu) => $typeLieu->getType())->toArray());
                }),
            IntegerField::new('moy_avis', 'Moyenne des avis')->setFormTypeOption('disabled', true),
            IntegerField::new('nb_avis', 'Nombre d\'avis')->setFormTypeOption('disabled', true),
        ];
    }
}
