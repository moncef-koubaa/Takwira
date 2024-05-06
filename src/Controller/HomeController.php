<?php

namespace App\Controller;

namespace App\Controller;

use App\Entity\Stadium;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(ManagerRegistry $doctrine): Response
    {
        {   $repository = $doctrine->getRepository(Stadium::class);
            $stadiums = $repository->findAll();
            return $this->render('home/index.html.twig', [
                'controller_name' => 'HomeController','stadiums'=>$stadiums
            ]);
        }
    }
    #[Route('/home', name: 'recherche')]
    public function stadiumbystate(ManagerRegistry $doctrine,$min,$max,$state,$date ): Response
    {   $repository = $doctrine->getRepository(Stadium::class);
        $stadiums = $repository->print($min,$max,$state,$date);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController','stadiums'=>$stadiums
        ]);
    }
}
