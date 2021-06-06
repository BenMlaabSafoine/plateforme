<?php

namespace App\Entity;

use App\Repository\GrilleTarifaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;



/**
 * @ORM\Entity(repositoryClass=GrilleTarifaireRepository::class)
 */
class GrilleTarifaire
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
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Offre::class, inversedBy="grilletarifaires")
     */
    private $offre;

    /**
     * @ORM\OneToMany(targetEntity=Reservation::class, mappedBy="grilleTarifaire")
     */
    private $reservations;

    /**
     * @ORM\Column(type="date")
     */
    private $date_debut;

    /**
     * @ORM\Column(type="date")
     */
    private $date_fin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prix;

    /**
     * @ORM\ManyToMany(targetEntity=Hotel::class, inversedBy="grilleTarifaires")
     */
    private $hotelgrille;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->hotelgrille = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getOffre(): ?Offre
    {
        return $this->offre;
    }

    public function setOffre(?Offre $offre): self
    {
        $this->offre = $offre;

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setGrilleTarifaire($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getGrilleTarifaire() === $this) {
                $reservation->setGrilleTarifaire(null);
            }
        }

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * @return Collection|Hotel[]
     */
    public function getHotelgrille(): Collection
    {
        return $this->hotelgrille;
    }

    public function addHotelgrille(Hotel $hotelgrille): self
    {
        if (!$this->hotelgrille->contains($hotelgrille)) {
            $this->hotelgrille[] = $hotelgrille;
        }

        return $this;
    }

    public function removeHotelgrille(Hotel $hotelgrille): self
    {
        $this->hotelgrille->removeElement($hotelgrille);

        return $this;
    }
}
