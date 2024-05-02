<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MonitorStadiumController extends AbstractController
{
    #[Route('/monitorStadium', name: 'app_monitor_stadium')]
    public function index(): Response
    {
        return $this->render('monitor_stadium/index.html.twig', [
            'controller_name' => 'MonitorStadiumController',
        ]);
    }
}
