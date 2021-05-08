<?php

namespace App\Entity;
use App\Entity\Offre;
use App\Repository\OmraRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OmraRepository::class)
 */
class Omra extends Offre
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
