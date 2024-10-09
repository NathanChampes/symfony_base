<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BurgerRepository;
use App\Entity\Burger;
use App\Form\BurgerType;
use Doctrine\ORM\EntityManagerInterface;

class BurgerController extends AbstractController
{
    #[Route('/burgers', name: 'burger_list')]
    public function list(): Response
    {
        $burgers = $this->getBurgers();

        return $this->render('burger_list.html.twig', [
            'burgers' => $burgers,
        ]);
    }

    #[Route('/burgers/db', name: 'burger_list_db')]
    public function listFromDatabase(BurgerRepository $burgerRepository): Response
    {
        $burgers = $burgerRepository->findAll();

        return $this->render('burger/list.html.twig', [
            'burgers' => $burgers,
        ]);
    }

    #[Route('/burgers/{id<\d+>}', name: 'burger_show')]
    public function show($id): Response
    {
        $burgers = $this->getBurgers();
        $burger = $burgers[$id - 1];

        return $this->render('burger_show.html.twig', [
            'burger' => $burger,
        ]);
    }


    #[Route('/burgers/ingredient/{ingredient?}', name: 'burger_list_by_ingredient')]
    public function listByIngredient(?string $ingredient, BurgerRepository $burgerRepository): Response
    {
        if ($ingredient) {
            $burgers = $burgerRepository->findBurgersWithIngredient($ingredient);
        } else {
            $burgers = $burgerRepository->findAll();
        }

        return $this->render('burger/list_by_ingredient.html.twig', [
            'burgers' => $burgers,
            'ingredient' => $ingredient,
        ]);
    }
    private function getBurgers(): array
    {
        return [
            ['id' => 1, 'name' => 'Cheeseburger', 'price' => 6.20, 'ingredients' => ['cheese', 'beef', 'lettuce']],
            ['id' => 2, 'name' => 'Hallouf Burger', 'price' => 6.68, 'ingredients' => ['halloumi', 'lettuce', 'tomato']],
            ['id' => 3, 'name' => 'Vegan Burger', 'price' => 4.99, 'ingredients' => ['tofu', 'lettuce', 'tomato']],
        ];
    }

    #[Route('/ingredients/suggestions', name: 'ingredient_suggestions')]
    public function ingredientSuggestions(Request $request, BurgerRepository $burgerRepository): Response
    {
        $term = $request->query->get('term');
        $ingredients = $burgerRepository->findIngredientsByTerm($term);
        return $this->json($ingredients);
    }

    #[Route('/burgers/new', name: 'burger_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $burger = new Burger();
        $form = $this->createForm(BurgerType::class, $burger);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($burger);
            $entityManager->flush();

            return $this->redirectToRoute('burger_list');
        }

        return $this->render('burger/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}