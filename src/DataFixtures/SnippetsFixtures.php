<?php

namespace App\DataFixtures;

use App\Entity\Snippet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class SnippetsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 50; $i++) {
            $snippet = new Snippet();
            $snippet
                ->setTitle($faker->words('3', true))
                ->setContent($faker->sentences('3', true));

            $manager->persist($snippet);
        }
        $manager->flush();
    }
}
