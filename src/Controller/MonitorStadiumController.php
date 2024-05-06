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
    #[Route('/stadiumOwner/monitorStadium', name: 'app_monitor_stadium')]
    public function index(ManagerRegistry $doctrine, Request $request): Response
    {
        // TODO make hierarchy in access control in security.yaml
        $this->denyAccessUnlessGranted('ROLE_OWNER');
        if (!$request->query->has('stadiumId')) {
            return new Response('No stadiumId provided', Response::HTTP_BAD_REQUEST);
        }
        $stadiumId = $request->query->get('stadiumId');
        $stadium = $doctrine->getRepository(Stadium::class)->find($stadiumId);
        if (!$stadium) {
            return new Response('Stadium not found', Response::HTTP_NOT_FOUND);
        }
//        if ($stadium->getOwner()->getUserIdentifier() !== $this->getUser()->getUserIdentifier()) {
//            return new Response('You are not the owner of this stadium', Response::HTTP_FORBIDDEN);
//        }
        return $this->render('monitor_stadium/index.html.twig', [
            'reservations' => $stadium->getReservations()
        ]);
    }
}
