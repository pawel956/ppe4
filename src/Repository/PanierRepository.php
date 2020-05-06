<?php

namespace App\Repository;

use App\Entity\Panier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Panier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Panier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Panier[]    findAll()
 * @method Panier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PanierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Panier::class);
    }

    /**
     * @param int $idCommande
     * @return int|mixed|string
     */
    public function numberProducts(int $idCommande)
    {
        return $this->createQueryBuilder('p')
            ->select('SUM(p.quantite) AS quantite')
            ->where('p.idCommande = :idCommande')
            ->setParameter('idCommande', $idCommande)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param int $idCommande
     * @return int|mixed|string
     */
    public function contenuPanier(int $idCommande)
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->join('p.idProduit', 'pr')
            ->where('p.idCommande = :idCommande')
            ->setParameter('idCommande', $idCommande)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Panier[] Returns an array of Panier objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Panier
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
