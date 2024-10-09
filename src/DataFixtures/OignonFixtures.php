<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Oignon;

class OignonFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $oignons = [
            'oignon1' => 'Oignon rouge',
            'oignon2' => 'Oignon blanc',
            'oignon3' => 'Oignon jaune',
            'oignon4' => 'Oignon doux',
            'oignon5' => 'Oignon vert',
        ];

        foreach ($oignons as $reference => $oignonName) {
            $oignon = new Oignon();
            $oignon->setName($oignonName);
            $manager->persist($oignon);
            $this->addReference($reference, $oignon);
        }

        $manager->flush();
    }
}