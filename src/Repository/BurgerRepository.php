<?php

namespace App\Repository;

use App\Entity\Burger;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Burger>
 *
 * @method Burger|null find($id, $lockMode = null, $lockVersion = null)
 * @method Burger|null findOneBy(array $criteria, array $orderBy = null)
 * @method Burger[]    findAll()
 * @method Burger[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BurgerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Burger::class);
    }

    /**
     * @return Burger[]
     */
    public function findBurgersWithIngredient(string $ingredient): array
    {
        return $this->createQueryBuilder('b')
            ->join('b.pain', 'p')
            ->join('b.oignons', 'o')
            ->join('b.sauces', 's')
            ->where('p.name = :ingredient OR o.name = :ingredient OR s.name = :ingredient')
            ->setParameter('ingredient', $ingredient)
            ->getQuery()
            ->getResult();
    }


    public function findIngredientsByTerm(string $term): array
    {
        $pains = $this->createQueryBuilder('b')
            ->select('DISTINCT p.name AS ingredient')
            ->join('b.pain', 'p')
            ->where('p.name LIKE :term')
            ->setParameter('term', '%' . $term . '%')
            ->getQuery()
            ->getArrayResult();

        $oignons = $this->createQueryBuilder('b')
            ->select('DISTINCT o.name AS ingredient')
            ->join('b.oignons', 'o')
            ->where('o.name LIKE :term')
            ->setParameter('term', '%' . $term . '%')
            ->getQuery()
            ->getArrayResult();

        $sauces = $this->createQueryBuilder('b')
            ->select('DISTINCT s.name AS ingredient')
            ->join('b.sauces', 's')
            ->where('s.name LIKE :term')
            ->setParameter('term', '%' . $term . '%')
            ->getQuery()
            ->getArrayResult();

        $ingredients = array_merge($pains, $oignons, $sauces);
        $ingredients = array_unique(array_column($ingredients, 'ingredient'));

        return $ingredients;
    }
}