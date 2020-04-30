<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Associer
 *
 * @ORM\Table(name="associer", indexes={@ORM\Index(name="id_produit", columns={"id_produit"}), @ORM\Index(name="id_genre_produit", columns={"id_genre_produit"})})
 * @ORM\Entity(repositoryClass="App\Repository\AssocierRepository")
 */
class Associer
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Produit
     *
     * @ORM\ManyToOne(targetEntity="Produit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_produit", referencedColumnName="id")
     * })
     */
    private $idProduit;

    /**
     * @var \GenreProduit
     *
     * @ORM\ManyToOne(targetEntity="GenreProduit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_genre_produit", referencedColumnName="id")
     * })
     */
    private $idGenreProduit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdProduit(): ?Produit
    {
        return $this->idProduit;
    }

    public function setIdProduit(?Produit $idProduit): self
    {
        $this->idProduit = $idProduit;

        return $this;
    }

    public function getIdGenreProduit(): ?GenreProduit
    {
        return $this->idGenreProduit;
    }

    public function setIdGenreProduit(?GenreProduit $idGenreProduit): self
    {
        $this->idGenreProduit = $idGenreProduit;

        return $this;
    }


}
