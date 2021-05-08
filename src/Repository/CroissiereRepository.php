<?php

namespace App\Repository;

use App\Entity\Croissiere;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Croissiere|null find($id, $lockMode = null, $lockVersion = null)
 * @method Croissiere|null findOneBy(array $criteria, array $orderBy = null)
 * @method Croissiere[]    findAll()
 * @method Croissiere[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CroissiereRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Croissiere::class);
    }

    // /**
    //  * @return Croissiere[] Returns an array of Croissiere objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Croissiere
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
