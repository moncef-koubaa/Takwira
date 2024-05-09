<?php

namespace App\Controller;

use App\Entity\Stadium;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ReserveStadiumController extends AbstractController
{
    #[Route('/reserve', name: 'app_reserve_stadium')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $stadiumId = $request->query->get('id');
        $repository = $doctrine->getRepository(Stadium::class);
        $stade=$repository->find($stadiumId);
        return $this->render('reserve_stadium/index.html.twig', [
            'controller_name' => 'ReserveStadiumController',
            'stadium' => $stade,
        ]);
    }
}
