<?php

namespace App\Repository;

use App\Entity\Compatible;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Compatible|null find($id, $lockMode = null, $lockVersion = null)
 * @method Compatible|null findOneBy(array $criteria, array $orderBy = null)
 * @method Compatible[]    findAll()
 * @method Compatible[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompatibleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Compatible::class);
    }

    // /**
    //  * @return Compatible[] Returns an array of Compatible objects
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
    public function findOneBySomeField($value): ?Compatible
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
