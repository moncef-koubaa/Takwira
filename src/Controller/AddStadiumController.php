<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AddStadiumController extends AbstractController
{
    #[Route('/addStadium', name: 'app_add_stadium')]
    public function index(): Response
    {
        return $this->render('add_stadium/index.html.twig', [

        ]);
    }
}
