<?php

namespace App\Repository;

use App\Entity\VoyageOrganiser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VoyageOrganiser|null find($id, $lockMode = null, $lockVersion = null)
 * @method VoyageOrganiser|null findOneBy(array $criteria, array $orderBy = null)
 * @method VoyageOrganiser[]    findAll()
 * @method VoyageOrganiser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoyageOrganiserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VoyageOrganiser::class);
    }

    // /**
    //  * @return VoyageOrganiser[] Returns an array of VoyageOrganiser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VoyageOrganiser
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
