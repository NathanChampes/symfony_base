<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\PainRepository; // Assurez-vous que le namespace est correct

class PainController extends AbstractController
{
    #[Route('/pain', name: 'app_pain')]
    public function index(): Response
    {
        return $this->render('pain/index.html.twig', [
            'controller_name' => 'PainController',
        ]);
    }

    #[Route('/pains', name: 'pain_list')]
    public function listFromDatabase(PainRepository $painRepository): Response
    {
        $pains = $painRepository->findAll();

        return $this->render('pain/list.html.twig', [
            'pains' => $pains,
        ]);
    }
}