<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OffreRepository::class)
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *  "croissiere" = "App\Entity\Croissiere",
 *  "excursion" = "App\Entity\Excursion",
 *  "omra" = "App\Entity\Omra",
 *  "randonnee" = "App\Entity\Randonnee",
 *  "offre" = "App\Entity\Offre",
 *  "voyageorganiser" = "App\Entity\VoyageOrganiser"})
 * @ORM\HasLifecycleCallbacks()
 */
class Offre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date_debut;

    /**
     * @ORM\Column(type="date")
     */
    private $date_fin;

    /**
     * @ORM\ManyToOne(targetEntity=AgenceVoyage::class, inversedBy="offres")
     * @ORM\JoinColumn(nullable=false)
     */
    private $agencevoyage;

    /**
     * @ORM\OneToMany(targetEntity=Reservation::class, mappedBy="offre")
     */
    private $Reservation;

    /**
     * @ORM\OneToMany(targetEntity=GrilleTarifaire::class, mappedBy="offre")
     */
    private $grilletarifaires;

    /**
     * @ORM\OneToMany(targetEntity=Photo::class, mappedBy="offre")
     */
    private $photos;

    /**
     * @ORM\ManyToMany(targetEntity=Pays::class, inversedBy="offres")
     */
    private $pays;

    /**
     * @ORM\ManyToMany(targetEntity=Hotel::class, inversedBy="offres")
     */
    private $hotels;

    public function __construct()
    {
        $this->Reservation = new ArrayCollection();
        $this->grilletarifaires = new ArrayCollection();
        $this->photos = new ArrayCollection();
        $this->pays = new ArrayCollection();
        $this->hotels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAgencevoyage(): ?AgenceVoyage
    {
        return $this->agencevoyage;
    }

    public function setAgencevoyage(?AgenceVoyage $agencevoyage): self
    {
        $this->agencevoyage = $agencevoyage;

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservation(): Collection
    {
        return $this->Reservation;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->Reservation->contains($reservation)) {
            $this->Reservation[] = $reservation;
            $reservation->setOffre($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->Reservation->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getOffre() === $this) {
                $reservation->setOffre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|GrilleTarifaire[]
     */
    public function getGrilletarifaires(): Collection
    {
        return $this->grilletarifaires;
    }

    public function addGrilletarifaire(GrilleTarifaire $grilletarifaire): self
    {
        if (!$this->grilletarifaires->contains($grilletarifaire)) {
            $this->grilletarifaires[] = $grilletarifaire;
            $grilletarifaire->setOffre($this);
        }

        return $this;
    }

    public function removeGrilletarifaire(GrilleTarifaire $grilletarifaire): self
    {
        if ($this->grilletarifaires->removeElement($grilletarifaire)) {
            // set the owning side to null (unless already changed)
            if ($grilletarifaire->getOffre() === $this) {
                $grilletarifaire->setOffre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Photo[]
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos[] = $photo;
            $photo->setOffre($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getOffre() === $this) {
                $photo->setOffre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Pays[]
     */
    public function getPays(): Collection
    {
        return $this->pays;
    }

    public function addPay(Pays $pay): self
    {
        if (!$this->pays->contains($pay)) {
            $this->pays[] = $pay;
        }

        return $this;
    }

    public function removePay(Pays $pay): self
    {
        $this->pays->removeElement($pay);

        return $this;
    }

    /**
     * @return Collection|Hotel[]
     */
    public function getHotels(): Collection
    {
        return $this->hotels;
    }

    public function addHotel(Hotel $hotel): self
    {
        if (!$this->hotels->contains($hotel)) {
            $this->hotels[] = $hotel;
        }

        return $this;
    }

    public function removeHotel(Hotel $hotel): self
    {
        $this->hotels->removeElement($hotel);

        return $this;
    }
}
