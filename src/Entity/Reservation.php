<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation")
 * @ORM\Entity
 */
class Reservation
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
     * @ORM\Column(name="date_reservation", type="datetime", nullable=true)
     * @Assert\NotBlank(
     * message="Choisir une date"
     * )
     */
    private $dateReservation ;

    /**
     * @var int
     *
     * @ORM\Column(name="iduser", type="integer", nullable=true)
     */
    private $iduser;

    /**
     * @var int
     *
     * @ORM\Column(name="nbr", type="integer", nullable=false)
     * @Assert\NotBlank(
     * message="Veuillez remplir ce champ"
     * )
     *  @Assert\Regex(
     *      pattern="/^[0-9,.]+$/",
     *     message="Entree seulement des chiffres"
     * )
     */
    private $nbr;

    

    /**
     * @var int|null
     *
     * @ORM\Column(name="volgenerique_id", type="integer", nullable=true)
     */
    private $volgeneriqueId = NULL;

    /**
     * @ORM\OneToOne(targetEntity=Facture::class, cascade={"persist", "remove"})
     */
    private $facture;

    

    public function getId(): ?int
    {
        return $this->id;
    }
    /**
     * @return \DateTimeInterface
     */
    public function getDateReservation(): ?\DateTimeInterface
    {
        return $this->dateReservation;
    }

    public function setDateReservation(?\DateTimeInterface $dateReservation): self
    {
        $this->dateReservation = $dateReservation;

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

    public function getNbr(): ?int
    {
        return $this->nbr;
    }

    public function setNbr(int $nbr): self
    {
        $this->nbr = $nbr;

        return $this;
    }

    

    public function getVolgeneriqueId(): ?int
    {
        return $this->volgeneriqueId;
    }

    public function setVolgeneriqueId(?int $volgeneriqueId): self
    {
        $this->volgeneriqueId = $volgeneriqueId;

        return $this;
    }

    public function getFacture(): ?Facture
    {
        return $this->facture;
    }

    public function setFacture(?Facture $facture): self
    {
        $this->facture = $facture;

        return $this;
    }

    

    /**
     * @ORM\ManyToOne(targetEntity=Vol::class, inversedBy="reservations")
     */
    private $vol;

    public function getVol(): ?Vol
    {
        return $this->vol;
    }

    public function setVol(?Vol $vol): self
    {
        $this->vol = $vol;

        return $this;
    }
}
