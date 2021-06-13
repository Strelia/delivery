<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class UserFixture extends Fixture
{
    const REF_USERS = 'REF_USERS_';

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();

        // Admin
        $admin = new User();
        $admin->setUsername('admin');
        $admin->setName('admin');
        $admin->setSurname('admin');
        $admin->setEmail('sys@delivery.com');
        $admin->setPlainPassword('root');
        $admin->setStatus(User::STATUS_VERIFIED);
        $admin->setIsVerified(true);
        $admin->setPhone($faker->phoneNumber);
        $admin->setRoles([User::ROLE_ADMIN]);
        $manager->persist($admin);

        // User
        foreach (range(0, 5) as $i) {
            $user = new User();
            [$name, $surname] = explode(' ', $faker->name());
            $user->setUsername($faker->userName);
            $user->setName($name);
            $user->setSurname($surname);
            $user->setEmail($faker->email);
            $user->setPlainPassword('test');
            $user->setStatus(User::STATUS_VERIFIED);
            $user->setIsVerified(true);
            $user->setPhone($faker->phoneNumber);
            $user->setRoles([User::ROLE_USER]);
            $manager->persist($user);
            $this->addReference(self::REF_USERS . $i, $user);
        }

        // Test User
        $user = new User();;
        $user->setUsername('test');
        $user->setName('User');
        $user->setSurname('Test');
        $user->setEmail('test@dilivery.com');
        $user->setPlainPassword('test');
        $user->setStatus(User::STATUS_VERIFIED);
        $user->setIsVerified(true);
        $user->setPhone($faker->phoneNumber);
        $user->setRoles([User::ROLE_USER]);
        $manager->persist($user);
        $this->addReference(self::REF_USERS .'test', $user);

        $manager->flush();
    }
}
