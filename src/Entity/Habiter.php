<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Habiter
 *
 * @ORM\Table(name="habiter", indexes={@ORM\Index(name="id_utilisateur", columns={"id_utilisateur"}), @ORM\Index(name="id_propriete", columns={"id_propriete"})})
 * @ORM\Entity(repositoryClass="App\Repository\HabiterRepository")
 */
class Habiter
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
     * @var bool|null
     *
     * @ORM\Column(name="defaut", type="boolean", nullable=true)
     */
    private $defaut;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_utilisateur", referencedColumnName="id")
     * })
     */
    private $idUtilisateur;

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

    public function getDefaut(): ?bool
    {
        return $this->defaut;
    }

    public function setDefaut(?bool $defaut): self
    {
        $this->defaut = $defaut;

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

    public function getIdUtilisateur(): ?Utilisateur
    {
        return $this->idUtilisateur;
    }

    public function setIdUtilisateur(?Utilisateur $idUtilisateur): self
    {
        $this->idUtilisateur = $idUtilisateur;

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
