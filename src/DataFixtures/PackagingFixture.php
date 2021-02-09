<?php

namespace App\DataFixtures;

use App\Entity\PackagingKind;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PackagingFixture extends Fixture
{
    const REF_PACKAGING = 'REF_PACKAGING_';

    public function load(ObjectManager $manager)
    {
        $packagingParent = new PackagingKind();
        $packagingParent->setName('packaging parent');
        $manager->persist($packagingParent);
        $this->addReference(self::REF_PACKAGING . 'parent', $packagingParent);

        foreach (range(0, 6) as $i) {
            $packaging = new PackagingKind();
            $packaging->setName("packaging $i");
            if ($i > 2 && $i < 4) {
                $packaging->setParent($packagingParent);
            }
            $manager->persist($packaging);
            $this->addReference(self::REF_PACKAGING . $i, $packaging);
        }

        $manager->flush();
    }
}
