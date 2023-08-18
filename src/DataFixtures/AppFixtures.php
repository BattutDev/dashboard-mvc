<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Faker\Generator;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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
        // Users
        $users = [];

        $admin = new User();
        $admin
            ->setFirstName('admin')
            ->setLastName('admin')
            ->SetEmail('admin@storage.box')
            ->setRoles(['ROLE_USER', 'ROLE_MANAGER', 'ROLE_ADMIN'])
            ->setPlainPassword('toto');

        $users[] = $admin;
        $manager->persist($admin);

        $userManager = new User();
        $userManager
            ->setFirstName('manager')
            ->setLastName('manager')
            ->SetEmail('manager@storage.box')
            ->setRoles(['ROLE_USER', 'ROLE_MANAGER'])
            ->setPlainPassword('toto');

        $users[] = $userManager;
        $manager->persist($admin);

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user
                ->setFirstName($this->faker->firstName())
                ->setLastName($this->faker->lastName())
                ->SetEmail($this->faker->email())
                ->setRoles(['ROLE_USER'])
                ->setPlainPassword('toto');

            $users[] = $user;
            $manager->persist($user);
        }

        $manager->flush();
    }
}
