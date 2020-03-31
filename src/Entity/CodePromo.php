<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CodePromo
 *
 * @ORM\Table(name="code_promo", indexes={@ORM\Index(name="id_type_code_promo", columns={"id_type_code_promo"})})
 * @ORM\Entity(repositoryClass="App\Repository\CodePromoRepository")
 */
class CodePromo
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
     * @var bool
     *
     * @ORM\Column(name="actif", type="boolean", nullable=false, options={"default"="1"})
     */
    private $actif = true;

    /**
     * @var string|null
     *
     * @ORM\Column(name="code", type="string", length=255, nullable=true)
     */
    private $code;

    /**
     * @var string|null
     *
     * @ORM\Column(name="reduction", type="string", length=50, nullable=true)
     */
    private $reduction;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_debut", type="datetime", nullable=true)
     */
    private $dateDebut;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_fin", type="datetime", nullable=true)
     */
    private $dateFin;

    /**
     * @var \TypeCodePromo
     *
     * @ORM\ManyToOne(targetEntity="TypeCodePromo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_type_code_promo", referencedColumnName="id")
     * })
     */
    private $idTypeCodePromo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getReduction(): ?string
    {
        return $this->reduction;
    }

    public function setReduction(?string $reduction): self
    {
        $this->reduction = $reduction;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(?\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(?\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getIdTypeCodePromo(): ?TypeCodePromo
    {
        return $this->idTypeCodePromo;
    }

    public function setIdTypeCodePromo(?TypeCodePromo $idTypeCodePromo): self
    {
        $this->idTypeCodePromo = $idTypeCodePromo;

        return $this;
    }


}
