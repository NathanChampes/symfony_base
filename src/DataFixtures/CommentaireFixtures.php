<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Commentaire;

class CommentaireFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $commentaires = [
            ['name'=> 'Commentaire 1','burger'=> 'burger1'],
            ['name'=> 'Commentaire 2','burger'=> 'burger2'],
            ['name'=> 'Commentaire 3','burger'=> 'burger3'],
            ['name'=> 'Commentaire 4','burger'=> 'burger4'],
            ['name'=> 'Commentaire 5','burger'=> 'burger5'],
        ];

        foreach ($commentaires as $index => $commentaireData) {
            $commentaire = new Commentaire();
            $commentaire->setName($commentaireData['name']);
            $commentaire->setBurger($this->getReference($commentaireData['burger']));
            $manager->persist($commentaire);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            BurgerFixtures::class,
        ];
    }
}