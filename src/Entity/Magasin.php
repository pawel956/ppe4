<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Magasin
 *
 * @ORM\Table(name="magasin", indexes={@ORM\Index(name="id_propriete", columns={"id_propriete"})})
 * @ORM\Entity(repositoryClass="App\Repository\MagasinRepository")
 */
class Magasin
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
     * @ORM\Column(name="horaire_ouverture", type="string", length=500, nullable=true)
     */
    private $horaireOuverture;

    /**
     * @var string|null
     *
     * @ORM\Column(name="longitude", type="string", length=50, nullable=true)
     */
    private $longitude;

    /**
     * @var string|null
     *
     * @ORM\Column(name="latitude", type="string", length=50, nullable=true)
     */
    private $latitude;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nom", type="string", length=50, nullable=true)
     */
    private $nom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="telephone", type="string", length=50, nullable=true)
     */
    private $telephone;

    /**
     * @var string|null
     *
     * @ORM\Column(name="courriel", type="string", length=255, nullable=true)
     */
    private $courriel;

    /**
     * @var \Propriete
     *
     * @ORM\ManyToOne(targetEntity="Propriete")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_propriete", referencedColumnName="id")
     * })
     */
    private $idPropriete;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHoraireOuverture(): ?string
    {
        return $this->horaireOuverture;
    }

    public function setHoraireOuverture(?string $horaireOuverture): self
    {
        $this->horaireOuverture = $horaireOuverture;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(?string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(?string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getCourriel(): ?string
    {
        return $this->courriel;
    }

    public function setCourriel(?string $courriel): self
    {
        $this->courriel = $courriel;

        return $this;
    }

    public function getIdPropriete(): ?Propriete
    {
        return $this->idPropriete;
    }

    public function setIdPropriete(?Propriete $idPropriete): self
    {
        $this->idPropriete = $idPropriete;

        return $this;
    }


}
