<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Image
 *
 * @ORM\Table(name="image", indexes={@ORM\Index(name="id_type_image", columns={"id_type_image"})})
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 */
class Image
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
     * @ORM\Column(name="chemin", type="string", length=255, nullable=true)
     */
    private $chemin;

    /**
     * @var \TypeImage
     *
     * @ORM\ManyToOne(targetEntity="TypeImage")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_type_image", referencedColumnName="id")
     * })
     */
    private $idTypeImage;

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

    public function getChemin(): ?string
    {
        return $this->chemin;
    }

    public function setChemin(?string $chemin): self
    {
        $this->chemin = $chemin;

        return $this;
    }

    public function getIdTypeImage(): ?TypeImage
    {
        return $this->idTypeImage;
    }

    public function setIdTypeImage(?TypeImage $idTypeImage): self
    {
        $this->idTypeImage = $idTypeImage;

        return $this;
    }


}
