<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ArtController extends AbstractController
{
    #[Route('/art', name: 'app_art_index')]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('art/index.html.twig', [
            'products' => $productRepository->findBy(['category' => 'art']),
        ]);
    }
}
