<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const USER_NUMBER = 10;
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
            $user->setEmail($faker->email());
            $user->setBirthdate($faker->dateTimeThisCentury());
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $faker->password(2, 6)
            );

            $user->setPassword($hashedPassword);
            $this->addReference('user' . $i, $user);
            $manager->persist($user);
        }

        $bilbo = new User();
        $bilbo->setUsername('bilbo');
        $bilbo->setEmail('bilbo@baggins.me');
        $bilbo->setBirthdate($faker->dateTimeThisCentury());

        $this->addReference('bilbo', $bilbo);

        $hashedPassword = $this->passwordHasher->hashPassword(
            $bilbo,
            'baggins'
        );
        $bilbo->setPassword($hashedPassword);
        $manager->persist($bilbo);

        $manager->flush();
    }
}
