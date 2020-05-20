<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande", indexes={@ORM\Index(name="id_code_promo", columns={"id_code_promo"}), @ORM\Index(name="id_propriete", columns={"id_propriete"}), @ORM\Index(name="id_utilisateur", columns={"id_utilisateur"}), @ORM\Index(name="id_mode_livraison", columns={"id_mode_livraison"})})
 * @ORM\Entity(repositoryClass="App\Repository\CommandeRepository")
 */
class Commande
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
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_commande", type="date", nullable=true)
     */
    private $dateCommande;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_livraison", type="date", nullable=true)
     */
    private $dateLivraison;

    /**
     * @var string|null
     *
     * @ORM\Column(name="facture_pdf", type="string", length=255, nullable=true)
     */
    private $facturePdf;

    /**
     * @var \ModeLivraison
     *
     * @ORM\ManyToOne(targetEntity="ModeLivraison", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_mode_livraison", referencedColumnName="id")
     * })
     */
    private $idModeLivraison;

    /**
     * @var \CodePromo
     *
     * @ORM\ManyToOne(targetEntity="CodePromo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_code_promo", referencedColumnName="id")
     * })
     */
    private $idCodePromo;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_utilisateur", referencedColumnName="id")
     * })
     */
    private $idUtilisateur;

    /**
     * @var \Propriete
     *
     * @ORM\ManyToOne(targetEntity="Propriete", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_propriete", referencedColumnName="id")
     * })
     */
    private $idPropriete;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->dateCommande;
    }

    public function setDateCommande(?\DateTimeInterface $dateCommande): self
    {
        $this->dateCommande = $dateCommande;

        return $this;
    }

    public function getDateLivraison(): ?\DateTimeInterface
    {
        return $this->dateLivraison;
    }

    public function setDateLivraison(?\DateTimeInterface $dateLivraison): self
    {
        $this->dateLivraison = $dateLivraison;

        return $this;
    }

    public function getFacturePdf(): ?string
    {
        return $this->facturePdf;
    }

    public function setFacturePdf(?string $facturePdf): self
    {
        $this->facturePdf = $facturePdf;

        return $this;
    }

    public function getIdModeLivraison(): ?ModeLivraison
    {
        return $this->idModeLivraison;
    }

    public function setIdModeLivraison(?ModeLivraison $idModeLivraison): self
    {
        $this->idModeLivraison = $idModeLivraison;

        return $this;
    }

    public function getIdCodePromo(): ?CodePromo
    {
        return $this->idCodePromo;
    }

    public function setIdCodePromo(?CodePromo $idCodePromo): self
    {
        $this->idCodePromo = $idCodePromo;

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
