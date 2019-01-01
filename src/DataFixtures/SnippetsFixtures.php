<?php

namespace App\DataFixtures;

use App\Entity\Language;
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
            $language = new Language();

            $snippet
                ->setTitle($faker->words('3', true))
                ->setContent($faker->realText($maxNbChars = 300, $indexSize = 2))
                ->addLanguage($language->setName($faker->colorName))
            ;

            $manager->persist($snippet);
        }
        $manager->flush();
    }
}
