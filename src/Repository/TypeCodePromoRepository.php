<?php

namespace App\Repository;

use App\Entity\TypeCodePromo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TypeCodePromo|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeCodePromo|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeCodePromo[]    findAll()
 * @method TypeCodePromo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeCodePromoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeCodePromo::class);
    }

    // /**
    //  * @return TypeCodePromo[] Returns an array of TypeCodePromo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeCodePromo
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
