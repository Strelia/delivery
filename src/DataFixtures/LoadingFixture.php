<?php

namespace App\DataFixtures;

use App\Entity\LoadingKind;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LoadingFixture extends Fixture
{
    const REF_LOADING = 'REF_LOADING_';

    public function load(ObjectManager $manager)
    {
        foreach (range(0, 4) as $i) {
            $loading = new LoadingKind();
            $loading->setName("Loading $i");
            $manager->persist($loading);
            $this->addReference(self::REF_LOADING . $i, $loading);
        }

        $manager->flush();
    }
}
