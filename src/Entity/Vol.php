<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Vol
 *
 * @ORM\Table(name="vol")
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Vol
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
     * @ORM\Column(name="date_arrivee", type="datetime", nullable=true)
     *  @Assert\NotBlank(
     * message="Veuillez remplir ce champ"
     * )
     */
    private $dateArrivee ;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_depart", type="datetime", nullable=true)
     *  @Assert\NotBlank(
     * message="Veuillez remplir ce champ"
     * )
     */
    private $dateDepart ;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lieu_arrive", type="string", length=255, nullable=true)
     *  @Assert\NotBlank(
     * message="Veuillez remplir ce champ"
     * )
     *  @Assert\Regex(
     *     pattern     = "/^[a-z]+$/i",
     *     htmlPattern = "[a-zA-Z]+",
     *     message="Entrer seulement des caracteres"
     * )
     */
    private $lieuArrive = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="lieu_depart", type="string", length=255, nullable=true)
     *  @Assert\NotBlank(
     * message="Veuillez remplir ce champ"
     * )
     *  @Assert\Regex(
     *     pattern     = "/^[a-z]+$/i",
     *     htmlPattern = "[a-zA-Z]+",
     * message="Entrer seulement des caracteres"
     * )
     */
    private $lieuDepart = 'NULL';

    /**
     * @var float
     *
     * @ORM\Column(name="montant", type="float", precision=10, scale=0, nullable=false)
     * @Assert\NotBlank(
     * message="Veuillez remplir ce champ"
     * )
     * @Assert\Regex(
     *     pattern="/^[0-9,.]+$/",
     *     message="Entrer seulement des chiffres"
     * )
     */
    private $montant;

    /**
     * @var int|null
     *
     * @ORM\Column(name="facture_id", type="integer", nullable=true)
     */
    private $factureId = NULL;

    /**
     * @ORM\OneToMany(targetEntity=Reservation::class, mappedBy="vol")
     */
    private $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateArrivee(): ?\DateTimeInterface
    {
        return $this->dateArrivee;
    }

    public function setDateArrivee(?\DateTimeInterface $dateArrivee): self
    {
        $this->dateArrivee = $dateArrivee;

        return $this;
    }

    public function getDateDepart(): ?\DateTimeInterface
    {
        return $this->dateDepart;
    }

    public function setDateDepart(?\DateTimeInterface $dateDepart): self
    {
        $this->dateDepart = $dateDepart;

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
     
    public function __toString(): string
    {
        return $this->getLieuDepart()."->".$this->getLieuArrive() ;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setVol($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getVol() === $this) {
                $reservation->setVol(null);
            }
        }

        return $this;
    }
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="vols_images", fileNameProperty="image")
     * @var File
     *  @Assert\Image(
     * mimeTypesMessage="Veuillez choisir une image")
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $updatedAt =null;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(
     * message="Veuillez remplir ce champ"
     * )
     * @Assert\Regex(
     *     pattern="/^[0-9]+$/",
     *     message="Entrer seulement des chiffres"
     * )
     */
    private $nbrdispo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbrreserve;

    // ...

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getNbrdispo(): ?int
    {
        return $this->nbrdispo;
    }

    public function setNbrdispo(int $nbrdispo): self
    {
        $this->nbrdispo = $nbrdispo;

        return $this;
    }

    public function getNbrreserve(): ?int
    {
        return $this->nbrreserve;
    }

    public function setNbrreserve(?int $nbrreserve): self
    {
        $this->nbrreserve = $nbrreserve;

        return $this;
    }

}
