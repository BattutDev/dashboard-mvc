<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Faker\Generator;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    /**
     * @var Generator
     */
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin
            ->setFirstName('John')
            ->setLastName('Doe')
            ->SetEmail('john.doe@dashboard.app')
            ->setRoles(['ROLE_USER', 'ROLE_MANAGER', 'ROLE_ADMIN'])
            ->setPlainPassword('toto');

        $manager->persist($admin);

        $userManager = new User();
        $userManager
            ->setFirstName('James')
            ->setLastName('Smith')
            ->SetEmail('james.smith@dashboard.app')
            ->setRoles(['ROLE_USER', 'ROLE_MANAGER'])
            ->setPlainPassword('toto');

        $manager->persist($userManager);

        $user = new User();
        $user
            ->setFirstName('Jane')
            ->setLastName('Doe')
            ->SetEmail('jane.doe@dashboard.app')
            ->setRoles(['ROLE_USER'])
            ->setPlainPassword('toto');

        $manager->persist($user);

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $first = $this->faker->firstName();
            $last = $this->faker->lastName();
            $user
                ->setFirstName($first)
                ->setLastName($last)
                ->SetEmail($first . $last . '@dashboard.app')
                ->setRoles(['ROLE_USER'])
                ->setPlainPassword('toto');

            $manager->persist($user);
        }

        $manager->flush();
    }
}
