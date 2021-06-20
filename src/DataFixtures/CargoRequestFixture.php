<?php

namespace App\DataFixtures;

use App\Entity\Cargo;
use App\Entity\CargoRequest;
use App\Workflow\CargoRequestTransitions;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CargoRequestFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        /**
         * @var $cargo Cargo
         */
        $cargo = $this->getReference(CargoFixture::REF_CARGO_OPEN);
        $cargoRequest = new CargoRequest();
        $cargoRequest->setExecutor($this->getReference(BusinessFixture::REF_BUSINESS . BusinessFixture::CAR));
        $cargoRequest->setCargo($cargo);
        $cargoRequest->setPrice($cargo->getPrice());
        $cargoRequest->setIsEditable(false);
        $cargoRequest->setStatus(CargoRequestTransitions::STATUS_SUBMITTED);
        $cargoRequest->setVolume($cargo->getVolume());
        $cargoRequest->setWeight($cargo->getWeight());

        $manager->persist($cargoRequest);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CargoFixture::class,
            BusinessFixture::class
        ];
    }
}
