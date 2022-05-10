<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Volgenerique
 *
 * @ORM\Table(name="volgenerique")
 * @ORM\Entity
 */
class Volgenerique
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
     * @ORM\Column(name="heure_depart", type="datetime", nullable=true)
     */
    private $heureDepart ;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="heurearrivee", type="datetime", nullable=true)
     */
    private $heurearrivee ;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lieu_arrive", type="string", length=255, nullable=true)
     */
    private $lieuArrive = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="lieu_depart", type="string", length=255, nullable=true)
     */
    private $lieuDepart = 'NULL';

    /**
     * @var float
     *
     * @ORM\Column(name="montant", type="float", precision=10, scale=0, nullable=false)
     */
    private $montant;

    /**
     * @var int|null
     *
     * @ORM\Column(name="facture_id", type="integer", nullable=true)
     */
    private $factureId = NULL;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHeureDepart(): ?\DateTimeInterface
    {
        return $this->heureDepart;
    }

    public function setHeureDepart(?\DateTimeInterface $heureDepart): self
    {
        $this->heureDepart = $heureDepart;

        return $this;
    }

    public function getHeurearrivee(): ?\DateTimeInterface
    {
        return $this->heurearrivee;
    }

    public function setHeurearrivee(?\DateTimeInterface $heurearrivee): self
    {
        $this->heurearrivee = $heurearrivee;

        return $this;
    }

    public function getLieuArrive(): ?string
    {
        return $this->lieuArrive;
    }

    public function setLieuArrive(?string $lieuArrive): self
    {
        $this->lieuArrive = $lieuArrive;

        return $this;
    }

    public function getLieuDepart(): ?string
    {
        return $this->lieuDepart;
    }

    public function setLieuDepart(?string $lieuDepart): self
    {
        $this->lieuDepart = $lieuDepart;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getFactureId(): ?int
    {
        return $this->factureId;
    }

    public function setFactureId(?int $factureId): self
    {
        $this->factureId = $factureId;

        return $this;
    }


}
