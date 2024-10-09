<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\SauceRepository; // Assurez-vous que le namespace est correct

class SauceController extends AbstractController
{
    #[Route('/sauce', name: 'app_sauce')]
    public function index(): Response
    {
        return $this->render('sauce/index.html.twig', [
            'controller_name' => 'SauceController',
        ]);
    }

    #[Route('/sauces', name: 'sauce_list')]
    public function listFromDatabase(SauceRepository $sauceRepository): Response
    {
        $sauces = $sauceRepository->findAll();

        return $this->render('sauce/list.html.twig', [
            'sauces' => $sauces,
        ]);
    }
}