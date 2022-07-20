<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LatestController extends AbstractController
{
    #[Route('/latest', name: 'app_latest')]
    public function index(): Response
    {
        return $this->render('latest/index.html.twig', [
            'controller_name' => 'LatestController',
        ]);
    }
}
