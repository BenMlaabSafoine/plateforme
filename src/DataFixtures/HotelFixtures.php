<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Hotel;

class HotelFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i=1;$i<=10;$i++){
            $hotel=new Hotel();
            $hotel->setNom("Nom d'Hotel n°$i")
                  ->setDescription("Description de l'hotel")
                  ->setImage("http//placehold.it/350*150");
            $manager->persist($hotel);
        }

        $manager->flush();
    }
}
