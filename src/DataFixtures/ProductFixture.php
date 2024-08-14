<?php

namespace App\DataFixtures;

use App\Entity\Products\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProductFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 20; $i++) {
            $categoryReference = $this->getReference(CategoryFixture::CATEGORY_REFERENCE . '_' . $i);

            $product = Product::create(
                $faker->word,                    // Name
                $faker->numberBetween(1, 100),   // Quantity
                $faker->randomFloat(2, 10, 1000),// Price
                $faker->paragraph,               // Description
                $faker->sentence,                // Product Use Guide
                $faker->imageUrl(400, 400, 'products'), // Image URL
                $faker->numberBetween(0, 50),    // Discount Percent
                $categoryReference->getId()      // Category ID
            );

            // Persist the product
            $manager->persist($product);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixture::class,
        ];
    }
}