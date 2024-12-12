<?php

namespace App\Controller\Admin;

use App\Entity\Avis;
use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AvisCrudController extends AbstractCrudController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getEntityFqcn(): string
    {
        return Avis::class;
    }

    public function configureFields(string $pageName): iterable
    {

        $emailField = TextField::new('user.email', 'Email de l\'utilisateur')
            ->setFormTypeOption('disabled', true);
        $lieu = AssociationField::new('lieu', 'Lieu')
            ->setRequired(true)
            ->setFormTypeOption('choice_label', 'nom');;
        $nivAvis = IntegerField::new('niv_avis', 'Note de l\'avis')
            ->setRequired(true);
        $com = TextField::new('com_avis', 'Votre avis')
            ->setRequired(true);

        return [$emailField, $lieu, $nivAvis, $com];
    }

    public function createEntity(string $entityFqcn)
    {
        $avis = new Avis();
        $user = $this->security->getUser();

        // Associe l'utilisateur connecté à l'avis
        if ($user instanceof User) {
            $avis->setUser($user);
        }

        return $avis;
    }
}
