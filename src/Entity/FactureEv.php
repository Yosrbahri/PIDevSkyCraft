<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FactureEv
 *
 
 * @ORM\Entity
 */
class FactureEv
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_facture_ev", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFactureEv;

    /**
     * @var int
     *
     * @ORM\Column(name="montant", type="integer", nullable=false)
     */
    private $montant;

    /**
     * @var int
     *
     * @ORM\Column(name="date_facture_eve", type="integer", nullable=false)
     */
    private $dateFactureEve;

  
    public function getIdFactureEv(): ?int
    {
        return $this->idFactureEv;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDateFactureEve(): ?int
    {
        return $this->dateFactureEve;
    }

    public function setDateFactureEve(int $dateFactureEve): self
    {
        $this->dateFactureEve = $dateFactureEve;

        return $this;
    }

    


}
