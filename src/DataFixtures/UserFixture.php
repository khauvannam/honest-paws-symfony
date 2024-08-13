<?php

namespace App\DataFixtures;

use App\Entity\Users\User;
use App\Entity\Users\UserVerify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 20; $i++) {
            $user = User::Create(
                $faker->userName,     // Username
                $faker->unique()->email  // Email
            );

            // Set a fake password and hash it
            $passwordHash = $this->passwordHasher->hashPassword($user, 'password');
            $user->setPassword($passwordHash);

            // Set other user properties
            $user->setAvatarLink($faker->imageUrl(100, 100, 'people')); // Avatar Link
            $user->setUserVerify(UserVerify::verify);
            // Add the user entity to the persistence layer
            $manager->persist($user);
        }

        // Persist the changes to the database
        $manager->flush();
    }

}