<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Pain;

class PainFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $pains = [
            'pain1' => 'Baguette',
            'pain2' => 'Pain de mie',
            'pain3' => 'Pain complet',
            'pain4' => 'Pain aux céréales',
            'pain5' => 'Pain de campagne',
        ];

        foreach ($pains as $reference => $painName) {
            $pain = new Pain();
            $pain->setName($painName);
            $manager->persist($pain);
            $this->addReference($reference, $pain);
        }

        $manager->flush();
    }
}