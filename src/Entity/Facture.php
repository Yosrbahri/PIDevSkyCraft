<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Facture
 *
 * @ORM\Table(name="facture")
 * @ORM\Entity
 */
class Facture
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
     * @var int
     *
     * @ORM\Column(name="designation", type="integer", nullable=true)
     */
    private $designation;

    /**
     * @var int
     *
     * @ORM\Column(name="nbr", type="integer", nullable=false)
     */
    private $nbr;

    /**
     * @var float
     *
     * @ORM\Column(name="prix_total", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixTotal;

    /**
     * @var float
     *
     * @ORM\Column(name="prix_unitaire", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixUnitaire;
    /**
     * @var int
     *
     * @ORM\Column(name="iduser", type="integer", nullable=true)
     */
    private $iduser;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?int
    {
        return $this->designation;
    }

    public function setDesignation(int $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getNbr(): ?int
    {
        return $this->nbr;
    }

    public function setNbr(int $nbr): self
    {
        $this->nbr = $nbr;

        return $this;
    }

    public function getPrixTotal(): ?float
    {
        return $this->prixTotal;
    }

    public function setPrixTotal(float $prixTotal): self
    {
        $this->prixTotal = $prixTotal;

        return $this;
    }

    public function getPrixUnitaire(): ?float
    {
        return $this->prixUnitaire;
    }

    public function setPrixUnitaire(float $prixUnitaire): self
    {
        $this->prixUnitaire = $prixUnitaire;

        return $this;
    }

    public function getIduser(): ?int
    {
        return $this->iduser;
    }

    public function setIduser(int $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }


}
