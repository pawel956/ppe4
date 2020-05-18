<?php

namespace App\Repository;

use App\Entity\Commande;
use App\Entity\Panier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

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
     * @param Commande $commande
     * @return int|mixed|string
     */
    public function numberProducts(Commande $commande)
    {
        return $this->createQueryBuilder('p')
            ->select('SUM(p.quantite) AS quantite')
            ->where('p.idCommande = :idCommande')
            ->setParameter('idCommande', $commande)
            ->getQuery()
            ->getResult()[0]['quantite'];
    }

    /**
     * @param Commande $commande
     * @param bool $array
     * @return int|mixed|string
     */
    public function contenuPanier(Commande $commande, bool $array)
    {
        return $this->createQueryBuilder('p')
            ->select('p, pr, t, pl')
            ->join('p.idProduit', 'pr')
            ->join('pr.idTypeProduit', 't')
            ->join('p.idPlateforme', 'pl')
            ->where('p.idCommande = :idCommande')
            ->setParameter('idCommande', $commande)
            ->getQuery()
            ->getResult($array ? Query::HYDRATE_ARRAY : null);
    }

    public function totalPanier(Commande $commande){
        return $this->createQueryBuilder('p')
            ->select('SUM(p.prix * p.quantite) AS total')
            ->where('p.idCommande = :idCommande')
            ->setParameter('idCommande', $commande)
            ->getQuery()
            ->getResult()[0]['total'];
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
