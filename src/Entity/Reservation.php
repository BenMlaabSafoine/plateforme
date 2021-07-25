<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
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
     * @ORM\ManyToOne(targetEntity=Offre::class, inversedBy="Reservation")
     */
    private $offre;

    /**
     * @ORM\ManyToOne(targetEntity=AgenceVoyage::class, inversedBy="reservations")
     */
    private $agenceVoyage;

    

    /**
     * @ORM\ManyToOne(targetEntity=GrilleTarifaire::class, inversedBy="reservations")
     */
    private $grilleTarifaire;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="reservations")
     */
    private $client;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $statut;

    public function __construct()
    {
        $this->clients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAgenceVoyage(): ?AgenceVoyage
    {
        return $this->agenceVoyage;
    }

    public function setAgenceVoyage(?AgenceVoyage $agenceVoyage): self
    {
        $this->agenceVoyage = $agenceVoyage;

        return $this;
    }

    /**
     * @return Collection|Client[]
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(Client $client): self
    {
        if (!$this->clients->contains($client)) {
            $this->clients[] = $client;
            $client->setReservations($this);
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->clients->removeElement($client)) {
            // set the owning side to null (unless already changed)
            if ($client->getReservations() === $this) {
                $client->setReservations(null);
            }
        }

        return $this;
    }

    public function getGrilleTarifaire(): ?GrilleTarifaire
    {
        return $this->grilleTarifaire;
    }

    public function setGrilleTarifaire(?GrilleTarifaire $grilleTarifaire): self
    {
        $this->grilleTarifaire = $grilleTarifaire;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }
}
