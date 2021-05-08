<?php

namespace App\Entity;

use App\Repository\AgenceVoyageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AgenceVoyageRepository::class)
 */
class AgenceVoyage
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numtel;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\OneToMany(targetEntity=Offre::class, mappedBy="agencevoyage")
     */
    private $offres;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="agenceVoyage")
     */
    private $Agents;

    /**
     * @ORM\OneToMany(targetEntity=Reservation::class, mappedBy="agenceVoyage")
     */
    private $reservations;

  


    public function __construct()
    {
        $this->offres = new ArrayCollection();
        $this->Agents = new ArrayCollection();
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
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

    public function getNumtel(): ?string
    {
        return $this->numtel;
    }

    public function setNumtel(string $numtel): self
    {
        $this->numtel = $numtel;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return Collection|Offre[]
     */
    public function getOffres(): Collection
    {
        return $this->offres;
    }

    public function addOffre(Offre $offre): self
    {
        if (!$this->offres->contains($offre)) {
            $this->offres[] = $offre;
            $offre->setAgencevoyage($this);
        }

        return $this;
    }

    public function removeOffre(Offre $offre): self
    {
        if ($this->offres->removeElement($offre)) {
            // set the owning side to null (unless already changed)
            if ($offre->getAgencevoyage() === $this) {
                $offre->setAgencevoyage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getAgents(): Collection
    {
        return $this->Agents;
    }
    public function getAgent(): array
    {  $t = [];
         foreach($this->Agents as $a ) {
            array_push($t,$a->getId()); }
        
    
        return $t;
    }


    public function addAgent(User $agent): self
    {
        if (!$this->Agents->contains($agent)) {
            $this->Agents[] = $agent;
            $agent->setAgenceVoyage($this);
        }

        return $this;
    }

    public function removeAgent(User $agent): self
    {
        if ($this->Agents->removeElement($agent)) {
            // set the owning side to null (unless already changed)
            if ($agent->getAgenceVoyage() === $this) {
                $agent->setAgenceVoyage(null);
            }
        }

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
            $reservation->setAgenceVoyage($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getAgenceVoyage() === $this) {
                $reservation->setAgenceVoyage(null);
            }
        }

        return $this;
    }


}
