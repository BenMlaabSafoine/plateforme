<?php

namespace App\Entity;
use App\Entity\Offre;
use App\Repository\VoyageOrganiserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VoyageOrganiserRepository::class)
 */
class VoyageOrganiser extends Offre
{
   

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $comprend;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $necomprendpas;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prixapartir;


    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getComprend(): ?string
    {
        return $this->comprend;
    }

    public function setComprend(string $comprend): self
    {
        $this->comprend = $comprend;

        return $this;
    }

    public function getNeComprendPas(): ?string
    {
        return $this->necomprendpas;
    }

    public function setNeComprendPas(string $necomprendpas): self
    {
        $this->necomprendpas = $necomprendpas;

        return $this;
    }

    public function getPrixAPartir(): ?string
    {
        return $this->prixapartir;
    }

    public function setPrixAPartir(string $prixapartir): self
    {
        $this->prixapartir = $prixapartir;

        return $this;
    }

    
}
