<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Sauce;

class SauceFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $sauces = [
            'sauce1' => 'Ketchup',
            'sauce2' => 'Mayonnaise',
            'sauce3' => 'Moutarde',
            'sauce4' => 'Barbecue',
            'sauce5' => 'Sauce piquante',
        ];

        foreach ($sauces as $reference => $sauceName) {
            $sauce = new Sauce();
            $sauce->setName($sauceName);
            $manager->persist($sauce);
            $this->addReference($reference, $sauce);
        }

        $manager->flush();
    }
}