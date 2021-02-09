<?php

namespace App\DataFixtures;

use App\Entity\CarBodyKind;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CarBodyFixture extends Fixture
{
    const REF_CAR_BODY = 'REF_CAR_BODY_';

    public function load(ObjectManager $manager)
    {
        foreach (range(0, 9) as $i) {
            $adr = new CarBodyKind();
            $adr->setName("CarBody $i");
            $manager->persist($adr);
            $this->addReference(self::REF_CAR_BODY . $i, $adr);
        }

        $manager->flush();

        $manager->flush();
    }
}
