<?php

namespace App\Repository;

use App\Entity\GenreProduit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GenreProduit|null find($id, $lockMode = null, $lockVersion = null)
 * @method GenreProduit|null findOneBy(array $criteria, array $orderBy = null)
 * @method GenreProduit[]    findAll()
 * @method GenreProduit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GenreProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GenreProduit::class);
    }

    // /**
    //  * @return GenreProduit[] Returns an array of GenreProduit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GenreProduit
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
