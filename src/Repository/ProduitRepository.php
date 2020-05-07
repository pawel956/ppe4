<?php

namespace App\Repository;

use App\Entity\Compatible;
use App\Entity\Image;
use App\Entity\Plateforme;
use App\Entity\Produit;
use App\Entity\TypeProduit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use MongoDB\BSON\Type;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    /**
     * @return array
     */
    public function findLastFourProducts()
    {
        $produits = $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();

        return [
            'produits' => $produits,
            'images' => $this->findProductsPictures($produits, false)
        ];
    }

    /**
     * @param $produits
     * @param bool $compatible
     * @return array
     */
    public function findProductsPictures($produits, bool $compatible = true)
    {
        $images = null;

        foreach ($produits as $produit) {
            $idProduit = $compatible ? $produit->getIdProduit()->getId() : $produit->getId();
            $images[$idProduit] = $this->getEntityManager()
                ->getRepository(Image::class)
                ->createQueryBuilder('i')
                ->where('i.idProduit = :idProduit')
                ->setParameter('idProduit', $idProduit)
                ->getQuery()
                ->getResult();
        }

        return $images;
    }

    public function findProductsByPlatform(Plateforme $plateforme, TypeProduit $typeProduit = null)
    {
        if (is_null($typeProduit)) {
            return $this->getEntityManager()
                ->getRepository(Compatible::class)
                ->createQueryBuilder('c')
                ->join('c.idProduit', 'p')
                ->where('c.idPlateforme = :idPlateforme')
                ->setParameter('idPlateforme', $plateforme)
                ->getQuery()
                ->getResult();
        }

        return $this->getEntityManager()
            ->getRepository(Compatible::class)
            ->createQueryBuilder('c')
            ->join('c.idProduit', 'p')
            ->where('c.idPlateforme = :idPlateforme')
            ->setParameter('idPlateforme', $plateforme)
            ->andWhere('p.idTypeProduit = :idTypeProduit')
            ->setParameter('idTypeProduit', $typeProduit)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Produit[] Returns an array of Produit objects
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
    public function findOneBySomeField($value): ?Produit
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
