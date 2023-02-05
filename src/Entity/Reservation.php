<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 * @Vich\Uploadable
 */
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numeroPermis;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateReservation;

     /**
     *
     * @Vich\UploadableField(mapping="reservation", fileNameProperty="imageName")
     *
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string|null
     */
    private $imageName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $finReservation;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $creatDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updateDate;

    /**
     * @ORM\ManyToOne(targetEntity=Voitures::class, inversedBy="reservations")
     */
    private $voitures;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $tarifLocation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dureeLocation;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="userreservation", cascade={"persist", "remove"})
     */
    private $reservationuser;
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getNumeroPermis(): ?int
    {
        return $this->numeroPermis;
    }

    public function setNumeroPermis(int $numeroPermis): self
    {
        $this->numeroPermis = $numeroPermis;

        return $this;
    }

    public function getDateReservation(): ?\DateTimeInterface
    {
        return $this->dateReservation;
    }

    public function setDateReservation(?\DateTimeInterface $dateReservation): self
    {
        $this->dateReservation = $dateReservation;

        return $this;
    }

    public function getFinReservation(): ?\DateTimeInterface
    {
        return $this->finReservation;
    }

    public function setFinReservation(?\DateTimeInterface $finReservation): self
    {
        $this->finReservation = $finReservation;

        return $this;
    }

     /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->creatDate = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function getCreatDate(): ?\DateTimeInterface
    {
        return $this->creatDate;
    }

    public function setCreatDate(?\DateTimeInterface $creatDate): self
    {
        $this->creatDate = $creatDate;

        return $this;
    }

    public function getUpdateDate(): ?\DateTimeInterface
    {
        return $this->updateDate;
    }

    public function setUpdateDate(?\DateTimeInterface $updateDate): self
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    public function getVoitures(): ?Voitures
    {
        return $this->voitures;
    }

    public function setVoitures(?Voitures $voitures): self
    {
        $this->voitures = $voitures;

        return $this;
    }


    public function getTarifLocation(): ?float
    {
        return $this->tarifLocation;
    }

    public function setTarifLocation(?float $tarifLocation): self
    {
        $this->tarifLocation = $tarifLocation;

        return $this;
    }

    public function getDureeLocation(): ?string
    {
        return $this->dureeLocation;
    }

    public function setDureeLocation(?string $dureeLocation): self
    {
        $this->dureeLocation = $dureeLocation;

        return $this;
    }

    public function getReservationuser(): ?User
    {
        return $this->reservationuser;
    }

    public function setReservationuser(?User $reservationuser): self
    {
        $this->reservationuser = $reservationuser;

        return $this;
    }
}
