<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Compatible
 *
 * @ORM\Table(name="compatible", indexes={@ORM\Index(name="id_plateforme", columns={"id_plateforme"}), @ORM\Index(name="id_produit", columns={"id_produit"})})
 * @ORM\Entity(repositoryClass="App\Repository\CompatibleRepository")
 */
class Compatible
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
     * @var int|null
     *
     * @ORM\Column(name="stock", type="integer", nullable=true)
     */
    private $stock;

    /**
     * @var \Produit
     *
     * @ORM\ManyToOne(targetEntity="Produit", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_produit", referencedColumnName="id")
     * })
     */
    private $idProduit;

    /**
     * @var \Plateforme
     *
     * @ORM\ManyToOne(targetEntity="Plateforme", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_plateforme", referencedColumnName="id")
     * })
     */
    private $idPlateforme;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(?int $stock): self
    {
        $this->stock = $stock;

        return $this;
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

    public function getIdPlateforme(): ?Plateforme
    {
        return $this->idPlateforme;
    }

    public function setIdPlateforme(?Plateforme $idPlateforme): self
    {
        $this->idPlateforme = $idPlateforme;

        return $this;
    }


}
