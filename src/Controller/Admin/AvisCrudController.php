<?php

namespace App\Controller\Admin;

use App\Entity\Avis;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

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
        $fields = [
            AssociationField::new('lieu', 'Lieu')
                ->setRequired(true)
                ->setFormTypeOption('choice_label', 'nom'),
            IntegerField::new('note', 'Note')->setRequired(true),
            TextareaField::new('commentaire', 'Commentaire')->setRequired(true),
        ];

        // Affiche l'email dans les vues INDEX et DETAIL
        if ($pageName === 'detail' || $pageName === 'index') {
            $fields[] = TextField::new('user.email', 'Email utilisateur')
                ->setFormTypeOption('disabled', true);
        }

        return $fields;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entity): void
    {
        // Forcer l'utilisateur connecté à être défini avant de persister l'entité
        if ($entity instanceof Avis) {
            $user = $this->security->getUser();
            if ($user instanceof User) {
                $entity->setUser($user);
            }
        }

        parent::persistEntity($entityManager, $entity);
        $this->updateLieuStats($entityManager, $entity);
    }

    public function deleteEntity(EntityManagerInterface $entityManager, $entity): void
    {
        parent::deleteEntity($entityManager, $entity);
        $this->updateLieuStats($entityManager, $entity);
    }

    private function updateLieuStats(EntityManagerInterface $entityManager, Avis $avis): void
    {
        $lieu = $avis->getLieu();
        if ($lieu) {
            $nbAvis = $lieu->getAvis()->count();
            $moyenne = $lieu->getAvis()->isEmpty()
                ? 0
                : array_sum($lieu->getAvis()->map(fn($a) => $a->getNote())->toArray()) / $nbAvis;

            $lieu->setNbAvis($nbAvis);
            $lieu->setMoyAvis(round($moyenne, 2));

            $entityManager->persist($lieu);
            $entityManager->flush();
        }
    }
}
