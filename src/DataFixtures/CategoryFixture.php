<?php

namespace App\DataFixtures;

use App\Entity\Categories\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixture extends Fixture
{
    public const CATEGORY_REFERENCE = 'category';

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 20; $i++) {
            $category = Category::create(
                $faker->word,                      // Name
                $faker->sentence,                  // Description
                $faker->imageUrl(400, 400, 'cats') // Image URL
            );

            // Persist the category
            $manager->persist($category);

            // Add a reference to use it later in the product fixture
            $this->addReference(self::CATEGORY_REFERENCE . '_' . $i, $category);
        }

        $manager->flush();
    }
}