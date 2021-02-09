<?php

namespace App\DataFixtures;

use App\Entity\Adr;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AdrFixture extends Fixture
{
    const REF_ADR = 'REF_ADR_';

    public function load(ObjectManager $manager)
    {
        foreach (range(0, 9) as $i) {
            $adr = new Adr();
            $adr->setName("Adr $i");
            $manager->persist($adr);
            $this->addReference(self::REF_ADR . $i, $adr);
        }

        $manager->flush();
    }
}
