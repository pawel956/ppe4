<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ModeLivraison
 *
 * @ORM\Table(name="mode_livraison")
 * @ORM\Entity(repositoryClass="App\Repository\ModeLivraisonRepository")
 */
class ModeLivraison
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
     * @ORM\Column(name="prix", type="decimal", precision=15, scale=2, nullable=true)
     */
    private $prix;

    /**
     * @var int|null
     *
     * @ORM\Column(name="delai", type="integer", nullable=true)
     */
    private $delai;

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

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(?string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDelai(): ?int
    {
        return $this->delai;
    }

    public function setDelai(?int $delai): self
    {
        $this->delai = $delai;

        return $this;
    }


}
