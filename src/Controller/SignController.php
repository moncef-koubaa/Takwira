<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SignController extends AbstractController
{
    #[Route('/sign', name: 'app_sign')]
    public function index(): Response
    {
        return $this->render('sign/index.html.twig', [
            'controller_name' => 'SignController',
        ]);
    }
}
