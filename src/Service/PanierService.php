<?php

namespace App\Service;

use App\Entity\Commande;
use App\Entity\Panier;
use App\Entity\Plateforme;
use App\Entity\Produit;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;

class PanierService
{
    protected $em;
    protected $repository;
    protected $commandeService;

    /**
     * PanierService constructor.
     *
     * @param EntityManagerInterface $em by dependency injection
     * @param CommandeService $commandeService
     */
    public function __construct(EntityManagerInterface $em, CommandeService $commandeService)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository(Panier::class);
        $this->commandeService = $commandeService;
    }

    /**
     * Save a Panier object in bdd
     *
     * @param Panier $panier
     */
    public function save(Panier $panier)
    {
        $this->em->persist($panier);
        $this->em->flush();
    }

    /**
     * Delete a Panier object in bdd
     *
     * @param Panier $panier
     */
    public function delete(Panier $panier)
    {
        $this->em->remove($panier);
        $this->em->flush();
    }

    /**
     * @param int $idUtilisateur
     * @return Utilisateur
     */
    public function getUtilisateur(int $idUtilisateur)
    {
        /** @var Utilisateur $utilisateur */
        $utilisateur = $this->em->getRepository(Utilisateur::class)->findOneBy(['id' => $idUtilisateur]);

        return $utilisateur;
    }

    /**
     * @param Utilisateur $utilisateur
     * @return Commande
     */
    public function getCommande(Utilisateur $utilisateur)
    {
        /** @var Commande $commande */
        $commande = $this->em->getRepository(Commande::class)->findOneBy(['idUtilisateur' => $utilisateur, 'dateCommande' => null]);

        if (is_null($commande)) {
            $commande = new Commande();
            $commande->setIdUtilisateur($utilisateur);
            $this->commandeService->save($commande);
        }

        return $commande;
    }

    /**
     * @param int $idProduit
     * @param int $idPlateforme
     * @param int $idUtilisateur
     * @return array|bool
     */
    public function getMainData(int $idProduit, int $idPlateforme, int $idUtilisateur)
    {
        $produit = $this->em->getRepository(Produit::class)->findOneBy(['id' => $idProduit]);
        $plateforme = $this->em->getRepository(Plateforme::class)->findOneBy(['id' => $idPlateforme]);
        $utilisateur = $this->getUtilisateur($idUtilisateur);

        if (is_null($produit) || is_null($plateforme) || is_null($utilisateur)) {
            return false;
        }

        $commande = $this->getCommande($utilisateur);

        return [
            'produit' => $produit,
            'plateforme' => $plateforme,
            'utilisateur' => $utilisateur,
            'commande' => $commande
        ];
    }

    /**
     * @param int $idProduit
     * @param int $idPlateforme
     * @param int $idUtilisateur
     * @return bool
     */
    public function addProduct(int $idProduit, int $idPlateforme, int $idUtilisateur)
    {
        $data = $this->getMainData($idProduit, $idPlateforme, $idUtilisateur);

        if (!$data) {
            return $data;
        }

        /** @var Panier $panier */
        $panier = $this->em->getRepository(Panier::class)->findOneBy(['idProduit' => $data['produit'], 'idPlateforme' => $data['plateforme'], 'idCommande' => $data['commande']]);

        if (is_null($panier)) {
            $panier = new Panier();
            $panier->setIdProduit($data['produit']);
            $panier->setIdPlateforme($data['plateforme']);
            $panier->setIdCommande($data['commande']);
            $panier->setQuantite(1);
        } else {
            $panier->setQuantite($panier->getQuantite() + 1);
        }

        $panier->setPrix(is_null($data['produit']->getPrixTemporaire()) ? $data['produit']->getPrix() : $data['produit']->getPrixTemporaire());
        $this->save($panier);

        return true;
    }

    /**
     * @param int $idProduit
     * @param int $idPlateforme
     * @param int $idUtilisateur
     * @return bool
     */
    public function removeProduct(int $idProduit, int $idPlateforme, int $idUtilisateur)
    {
        $data = $this->getMainData($idProduit, $idPlateforme, $idUtilisateur);

        if (!$data) {
            return $data;
        }

        /** @var Panier $panier */
        $panier = $this->em->getRepository(Panier::class)->findOneBy(['idProduit' => $data['produit'], 'idPlateforme' => $data['plateforme'], 'idCommande' => $data['commande']]);

        if (is_null($panier)) {
            return false;
        }

        $this->delete($panier);

        return true;
    }

    /**
     * @param int $idUtilisateur
     * @param bool $array
     * @return array
     */
    public function panierData(int $idUtilisateur, bool $array = false)
    {
        $commande = $this->getCommande($this->getUtilisateur($idUtilisateur));
        $panierRepository = $this->em->getRepository(Panier::class);

        $data = [
            'contenu' => $panierRepository->contenuPanier($commande, $array),
            'quantite' => $panierRepository->numberProducts($commande)
        ];

        $data['quantite'] = is_null($data['quantite']) ? "0" : $data['quantite'];

        return $data;
    }
}
