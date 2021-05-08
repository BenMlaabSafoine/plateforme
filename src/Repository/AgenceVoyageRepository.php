<?php

namespace App\Repository;

use App\Entity\AgenceVoyage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AgenceVoyage|null find($id, $lockMode = null, $lockVersion = null)
 * @method AgenceVoyage|null findOneBy(array $criteria, array $orderBy = null)
 * @method AgenceVoyage[]    findAll()
 * @method AgenceVoyage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AgenceVoyageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AgenceVoyage::class);
    }

    // /**
    //  * @return AgenceVoyage[] Returns an array of AgenceVoyage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AgenceVoyage
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
