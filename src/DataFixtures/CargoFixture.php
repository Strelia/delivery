<?php

namespace App\DataFixtures;

use App\Entity\Cargo;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class CargoFixture extends Fixture implements DependentFixtureInterface
{
    const REF_CARGO = 'REF_CARGO_';
    protected string $dateFormat = 'y-m-d';

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();

        $cargoHideUser = $this->getCargo($faker, "hideUser");
        $cargoHideUser->setPaymentKind(Cargo::PAYMENT_TYPE_FIXED);
        $cargoHideUser->setStatus(Cargo::STATUS_OPEN);
        $cargoHideUser->setIsHiddenUserRequest(true);

        $cargoHideUser = $this->getCargo($faker, "hideUser");
        $cargoHideUser->setPaymentKind(Cargo::PAYMENT_TYPE_FIXED);
        $cargoHideUser->setStatus(Cargo::STATUS_OPEN);

        $cargoOpen = $this->getCargo($faker, "open");
        $cargoOpen->setPaymentKind(Cargo::PAYMENT_TYPE_FIXED);
        $cargoOpen->setStatus(Cargo::STATUS_OPEN);

        $cargoClose = $this->getCargo($faker, "close");
        $cargoClose->setPaymentKind(Cargo::PAYMENT_TYPE_FIXED);
        $cargoClose->setStatus(Cargo::STATUS_CLOSE);

        $cargoHideUser->setAdr($this->getReference(AdrFixture::REF_ADR . "1"));
        foreach (range(1, 3) as $i) {
            $cargoHideUser->addLoadingKind($this->getReference(LoadingFixture::REF_LOADING . $i));
        }
        foreach (range(2, 4) as $i) {
            $cargoHideUser->addUnloadingType($this->getReference(LoadingFixture::REF_LOADING . $i));
        }

        $business = $this->getReference(BusinessFixture::REF_BUSINESS . BusinessFixture::CARGO);
        $cargoHideUser->setOwner($business);
        $cargoOpen->setOwner($business);
        $cargoClose->setOwner($business);

        $manager->persist($cargoHideUser);
        $manager->persist($cargoOpen);
        $manager->persist($cargoClose);

        $manager->flush();
    }

    public function getCargo(Faker\Generator $faker, string $suffix): Cargo
    {
        $cargo = new Cargo();
        $cargo->setName("Cargo $suffix");
        $cargo->setWeight($faker->numberBetween(2, 1000));
        $cargo->setVolume($faker->numberBetween(100, 200));
        $cargo->setAddressFrom("$faker->country $faker->city $faker->streetName, $faker->buildingNumber");
        $cargo->setAddressTo("$faker->country $faker->city $faker->streetName, $faker->buildingNumber");
        $cargo->setCountCars($faker->numberBetween(1, 3));
        $dateMin = new DateTime($faker->date('y-m-d', '+5d'));
        $dateMin->format($this->dateFormat);
        $cargo->setDateStartMin($dateMin);

        $dateMax = new DateTime($faker->date('y-m-d', '+6d'));
        $dateMax->format($this->dateFormat);
        $cargo->setDateStartMax($dateMax);
        $cargo->setPrice($faker->numberBetween(1000, 10000));
        return $cargo;
    }

    public function getDependencies(): array
    {
        return [
            BusinessFixture::class,
            LoadingFixture::class,
            AdrFixture::class,
            PackagingFixture::class
        ];
    }
}
