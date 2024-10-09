<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Image;

class ImageFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $images = [
            'image1' => 'image1.jpg',
            'image2' => 'image2.jpg',
            'image3' => 'image3.jpg',
            'image4' => 'image4.jpg',
            'image5' => 'image5.jpg',
        ];

        foreach ($images as $reference => $imageName) {
            $image = new Image();
            $image->setName($imageName);
            $manager->persist($image);
            $this->addReference($reference, $image);
        }

        $manager->flush();
    }
}