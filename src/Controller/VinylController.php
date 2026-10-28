<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VinylController extends AbstractController
{
    #[Route('/vinyl', name: 'app_vinyl_index')]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('vinyl/index.html.twig', [
            'products' => $productRepository->findBy(['category' => 'vinyl']),
            'title' => 'Collection Vinyles',
            'image' => 'https://images.unsplash.com/photo-1603048588665-791ca8aea617?q=80&w=2000'
        ]);
    }

    #[Route('/profile', name: 'app_profile')]
    public function profile(OrderRepository $orderRepository): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('profile.html.twig', [
            'orders' => $orderRepository->findBy(['user' => $this->getUser()]),
        ]);
    }
}
