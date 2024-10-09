<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ImageRepository; // Assurez-vous que le namespace est correct

class ImageController extends AbstractController
{
    #[Route('/image', name: 'app_image')]
    public function index(): Response
    {
        return $this->render('image/index.html.twig', [
            'controller_name' => 'ImageController',
        ]);
    }

    #[Route('/images', name: 'image_list')]
    public function listFromDatabase(ImageRepository $imageRepository): Response
    {
        $images = $imageRepository->findAll();

        return $this->render('image/list.html.twig', [
            'images' => $images,
        ]);
    }
}