<?php

namespace App\Repository;

use App\Entity\Habiter;
use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Habiter|null find($id, $lockMode = null, $lockVersion = null)
 * @method Habiter|null findOneBy(array $criteria, array $orderBy = null)
 * @method Habiter[]    findAll()
 * @method Habiter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HabiterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Habiter::class);
    }

    public function getFullDefaultAddress(Utilisateur $utilisateur)
    {
        return $this->createQueryBuilder('h')
            ->select('h, p, a, v, r, pa')
            ->join('h.idPropriete', 'p')
            ->join('p.idAdresse', 'a')
            ->join('a.idVille', 'v')
            ->join('v.idRegion', 'r')
            ->join('r.idPays', 'pa')
            ->where('h.defaut = true')
            ->andWhere('h.idUtilisateur = :idUtilisateur')
            ->setParameter('idUtilisateur', $utilisateur)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Habiter[] Returns an array of Habiter objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Habiter
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
