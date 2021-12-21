<?php

namespace App\DataFixtures;

use App\Entity\Touit;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TouitFixtures extends Fixture implements DependentFixtureInterface
{
    public const MAX_TOUIT = 100;
    public const USER_TOUIT = 10;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < self::MAX_TOUIT; $i++) {
            $touit = new Touit();
            $touit->setMessage($faker->text(120));
            $touit->setUser($this->getReference('user' . rand(0, UserFixtures::USER_NUMBER - 1)));
            $manager->persist($touit);
        }

        for ($i = 0; $i < self::USER_TOUIT; $i++) {
            $touit = new Touit();
            $touit->setMessage($faker->text(120));
            $touit->setUser($this->getReference('bilbo'));
            $manager->persist($touit);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
