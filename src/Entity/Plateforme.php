<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Plateforme
 *
 * @ORM\Table(name="plateforme", indexes={@ORM\Index(name="id_marque", columns={"id_marque"})})
 * @ORM\Entity(repositoryClass="App\Repository\PlateformeRepository")
 */
class Plateforme
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
