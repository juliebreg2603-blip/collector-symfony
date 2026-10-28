<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlindTestController extends AbstractController
{
    #[Route('/blind/test', name: 'app_blind_test')]
    public function index(): Response
    {
        return $this->render('blind_test/index.html.twig', [
            'image' => 'https://images.unsplash.com/photo-1614613535308-eb5fbd3d2c17?q=80&w=1000&auto=format&fit=crop',
            'reponse' => 'Random Access Memories - Daft Punk',
            'indice' => 'Un duo de robots français très célèbre.'
        ]);
    }
}
