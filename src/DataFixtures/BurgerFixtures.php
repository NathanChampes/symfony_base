<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Burger;

class BurgerFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $burgers = [
            'burger1'=> ['name' => 'Cheeseburger', 'price' => 6.20, 'pain' => 'pain1', 'oignons' => ['oignon1', 'oignon2'], 'sauces' => ['sauce1'], 'image' => 'image1'],
            'burger2'=>['name' => 'Hallouf Burger', 'price' => 6.68, 'pain' => 'pain2', 'oignons' => ['oignon3'], 'sauces' => ['sauce2'], 'image' => 'image2'],
            'burger3'=>['name' => 'Vegan Burger', 'price' => 4.99, 'pain' => 'pain3', 'oignons' => ['oignon4'], 'sauces' => ['sauce3'], 'image' => 'image3'],
            'burger4'=>['name' => 'Chicken Burger', 'price' => 5.50, 'pain' => 'pain4', 'oignons' => ['oignon5'], 'sauces' => ['sauce4'], 'image' => 'image4'],
            'burger5'=>['name' => 'Fish Burger', 'price' => 5.80, 'pain' => 'pain5', 'oignons' => ['oignon1', 'oignon3'], 'sauces' => ['sauce5'], 'image' => 'image5'],
        ];

        foreach ($burgers as $reference => $burgerData) {
            $burger = new Burger();
            $burger->setName($burgerData['name']);
            $burger->setPrice($burgerData['price']);
            $burger->setPain($this->getReference($burgerData['pain']));
            
            foreach ($burgerData['oignons'] as $oignonRef) {
                $burger->addOignon($this->getReference($oignonRef));
            }
            
            foreach ($burgerData['sauces'] as $sauceRef) {
                $burger->addSauce($this->getReference($sauceRef));
            }
            $burger->setImage($this->getReference($burgerData['image']));
            
            $manager->persist($burger);
            $this->addReference($reference, $burger);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            PainFixtures::class,
            OignonFixtures::class,
            SauceFixtures::class,
            ImageFixtures::class,
        ];
    }
}