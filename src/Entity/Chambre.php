<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Chambre
 *
 * 
 * @ORM\Entity
 */
class Chambre
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_cham", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCham;

    /**
     * @var int
     *
     * @ORM\Column(name="num_cham", type="integer", nullable=false)
     */
    private $numCham;

    /**
     * @var \Hotel
     *
     * @ORM\ManyToOne(targetEntity="Hotel")
   
     */
    private $idHotel;

    public function getIdCham(): ?int
    {
        return $this->idCham;
    }

    public function getNumCham(): ?int
    {
        return $this->numCham;
    }

    public function setNumCham(int $numCham): self
    {
        $this->numCham = $numCham;

        return $this;
    }

    public function getIdHotel(): ?Hotel
    {
        return $this->idHotel;
    }

    public function setIdHotel(?Hotel $idHotel): self
    {
        $this->idHotel = $idHotel;

        return $this;
    }


}
