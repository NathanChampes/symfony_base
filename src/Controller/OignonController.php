<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\OignonRepository; // Assurez-vous que le namespace est correct

class OignonController extends AbstractController
{
    #[Route('/oignon', name: 'app_oignon')]
    public function index(): Response
    {
        return $this->render('oignon/index.html.twig', [
            'controller_name' => 'OignonController',
        ]);
    }

    #[Route('/oignons', name: 'oignon_list')]
    public function listFromDatabase(OignonRepository $oignonRepository): Response
    {
        $oignons = $oignonRepository->findAll();

        return $this->render('oignon/list.html.twig', [
            'oignons' => $oignons,
        ]);
    }
}