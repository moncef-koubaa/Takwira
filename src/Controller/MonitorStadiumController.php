<?php

namespace App\Controller;

use App\Entity\Stadium;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MonitorStadiumController extends AbstractController
{
    #[Route('/monitorStadium', name: 'app_monitor_stadium')]
    public function index(ManagerRegistry $doctrine, Request $request): Response
    {
        dump($request);
        $stadiumId = 44;
        $stadium = $doctrine->getRepository(Stadium::class)->find($stadiumId);
        return $this->render('monitor_stadium/index.html.twig', [
            'reservations' => $stadium->getReservations()
        ]);
    }
}
