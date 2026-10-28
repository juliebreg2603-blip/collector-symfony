<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CdController extends AbstractController
{
    #[Route('/cd', name: 'app_cd_index')]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('cd/index.html.twig', [
            'products' => $productRepository->findBy(['category' => 'cd']),
        ]);
    }
}
