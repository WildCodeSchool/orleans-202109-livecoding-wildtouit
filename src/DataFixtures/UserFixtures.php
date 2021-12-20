<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const USER_NUMBER = 25;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < self::USER_NUMBER; $i++) {
            $user = new User();
            $user->setUsername($faker->userName());

            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $faker->password(2, 6)
            );

            $user->setPassword($hashedPassword);
            $manager->persist($user);
        }

        $user = new User();
        $user->setUsername('bilbo');

        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            'baggins'
        );
        $user->setPassword($hashedPassword);
        $manager->persist($user);

        $manager->flush();
    }
}
