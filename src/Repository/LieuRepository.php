<?php

namespace App\Repository;

use App\Entity\Lieu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Lieu>
 */
class LieuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lieu::class);
    }

    /**
     * @param string $type Le type de lieu à rechercher
     * @return Lieu[] Retourne un tableau de lieux filtrés par type
     */
    public function findByType(string $type): array
    {
        return $this->createQueryBuilder('l')
            ->innerJoin('l.typeLieux', 't')
            ->andWhere('t.type = :type')
            ->setParameter('type', $type)
            ->orderBy('l.nom', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
