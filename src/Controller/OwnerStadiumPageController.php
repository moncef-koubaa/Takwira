<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OwnerStadiumPageController extends AbstractController
{
    #[Route('/ownerStadiumPage', name: 'app_owner_stadium_page')]
    public function index(): Response
    {
        //test test
        return $this->render('owner_stadium_page/index.html.twig', [
            'amir' => 50,
        ]);
    }
}
