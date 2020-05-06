<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 *
 * @ORM\Table(name="produit", indexes={@ORM\Index(name="id_marque", columns={"id_marque"}), @ORM\Index(name="id_type_produit", columns={"id_type_produit"})})
 * @ORM\Entity(repositoryClass="App\Repository\ProduitRepository")
 */
class Produit
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
     * @var string|null
     *
     * @ORM\Column(name="libelle", type="string", length=255, nullable=true)
     */
    private $libelle;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="prix", type="decimal", precision=15, scale=2, nullable=true)
     */
    private $prix;

    /**
     * @var string|null
     *
     * @ORM\Column(name="prix_temporaire", type="decimal", precision=15, scale=2, nullable=true)
     */
    private $prixTemporaire;

    /**
     * @var \TypeProduit
     *
     * @ORM\ManyToOne(targetEntity="TypeProduit", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_type_produit", referencedColumnName="id")
     * })
     */
    private $idTypeProduit;

    /**
     * @var \Marque
     *
     * @ORM\ManyToOne(targetEntity="Marque", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_marque", referencedColumnName="id")
     * })
     */
    private $idMarque;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(?string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getPrixTemporaire(): ?string
    {
        return $this->prixTemporaire;
    }

    public function setPrixTemporaire(?string $prixTemporaire): self
    {
        $this->prixTemporaire = $prixTemporaire;

        return $this;
    }

    public function getIdTypeProduit(): ?TypeProduit
    {
        return $this->idTypeProduit;
    }

    public function setIdTypeProduit(?TypeProduit $idTypeProduit): self
    {
        $this->idTypeProduit = $idTypeProduit;

        return $this;
    }

    public function getIdMarque(): ?Marque
    {
        return $this->idMarque;
    }

    public function setIdMarque(?Marque $idMarque): self
    {
        $this->idMarque = $idMarque;

        return $this;
    }


}
