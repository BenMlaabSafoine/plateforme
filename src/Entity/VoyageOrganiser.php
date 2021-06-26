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


    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    
}
