<?php

namespace App\DataFixtures;

use App\Entity\Business;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class BusinessFixture extends Fixture implements DependentFixtureInterface
{
    const REF_BUSINESS = 'REF_BUSINESS_';
    const CARGO = 'CARGO_';
    const CAR = 'CAR_';

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();
        // Cargo
        $businessCargo = $this->getBusiness($faker);
        $businessCargo->setStatus(Business::STATUS_CONFIRM);
        $businessCargo->setOccupations([Business::OCCUPATIONS_CARGO_OWNER]);
        $businessCargo->setAgencyType(Business::AGENCY_JURIDICAL_PERSON);
        foreach (range(1, 5) as $i) {
            $businessCargo->addStaff($this->getReference(UserFixture::REF_USERS.$i));
        }
        $businessCargo->addStaff($this->getReference(UserFixture::REF_USERS .'test'));
        $manager->persist($businessCargo);
        $this->addReference(self::REF_BUSINESS . self::CARGO, $businessCargo);

        // Car
        $businessCar = $this->getBusiness($faker);
        $businessCar->setStatus(Business::STATUS_NEW);
        $businessCar->setOccupations([Business::OCCUPATIONS_CAR_OWNER]);
        $businessCar->setAgencyType(Business::AGENCY_NATURAL_PERSON);
        $businessCar->addStaff($this->getReference(UserFixture::REF_USERS. '0'));
        $manager->persist($businessCar);
        $this->addReference(self::REF_BUSINESS . self::CAR, $businessCar);

        $manager->flush();
    }

    protected function getBusiness(Faker\Generator $faker): Business
    {
        $business = new Business();
        $name = $faker->company;
        $business->setName($name);
        $business->setEmail($faker->email);
        $business->setInternationalName($name);
        $business->setWebURL($faker->url);
        $business->setAddress("$faker->country $faker->city $faker->streetName, $faker->buildingNumber");

        return $business;
    }

    public function getDependencies(): array
    {
        return [UserFixture::class];
    }
}
