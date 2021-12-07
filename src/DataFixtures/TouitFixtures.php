<?php

namespace App\DataFixtures;

use App\Entity\Touit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TouitFixtures extends Fixture
{
    public const MAX_TOUIT = 100;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < self::MAX_TOUIT; $i++) {
            $touit = new Touit();
            $touit->setMessage($faker->text(120));
            $manager->persist($touit);
        }


        $manager->flush();
    }
}
