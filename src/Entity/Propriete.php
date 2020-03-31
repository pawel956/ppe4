<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Propriete
 *
 * @ORM\Table(name="propriete", indexes={@ORM\Index(name="id_adresse", columns={"id_adresse"})})
 * @ORM\Entity(repositoryClass="App\Repository\ProprieteRepository")
 */
class Propriete
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
     * @ORM\Column(name="numero_rue", type="string", length=255, nullable=true)
     */
    private $numeroRue;

    /**
     * @var string|null
     *
     * @ORM\Column(name="info_comp", type="string", length=255, nullable=true)
     */
    private $infoComp;

    /**
     * @var \Adresse
     *
     * @ORM\ManyToOne(targetEntity="Adresse")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_adresse", referencedColumnName="id")
     * })
     */
    private $idAdresse;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroRue(): ?string
    {
        return $this->numeroRue;
    }

    public function setNumeroRue(?string $numeroRue): self
    {
        $this->numeroRue = $numeroRue;

        return $this;
    }

    public function getInfoComp(): ?string
    {
        return $this->infoComp;
    }

    public function setInfoComp(?string $infoComp): self
    {
        $this->infoComp = $infoComp;

        return $this;
    }

    public function getIdAdresse(): ?Adresse
    {
        return $this->idAdresse;
    }

    public function setIdAdresse(?Adresse $idAdresse): self
    {
        $this->idAdresse = $idAdresse;

        return $this;
    }


}
