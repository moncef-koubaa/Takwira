<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Stadium;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PaymentController extends AbstractController
{
    #[Route('/payment', name: 'app_payment')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $stadiumId = $request->query->get('stadiumId');
        $date= $request->query->get('date');

        $time= $request->query->get('time');

        $repository = $doctrine->getRepository(Stadium::class);
        $stadium=$repository->find($stadiumId);
        return $this->render('payment/index.html.twig', [
            'controller_name' => 'PaymentController',
            'date' => $date,
            'time' => $time,
            'stadiumId' => $stadiumId,
            'stadium' => $stadium,
        ]);
    }
    #[Route('/paymentSuccessfull', name: 'paymentSuccessfull')]
    public function paymentSuccessfull(Request $request, ManagerRegistry $doctrine,EntityManagerInterface $entityManager): Response
    {
        $stadiumId = $request->query->get('stadiumId');
        $dateString= $request->query->get('date');
        $date = \DateTime::createFromFormat('j M Y', $dateString);
        $startHour= $request->query->get('time');
        $startHourInt=intval($startHour);
        $endHour = $startHourInt+1;
        $startTime = new DateTime();
        $endTime = new DateTime();
        $startTime->setTime($startHour, 0);
        $endTime->setTime($endHour, 0);
        $repository = $doctrine->getRepository(Stadium::class);
        $stadium=$repository->find($stadiumId);
        $user=$this->getUser();
        $reservation = new Reservation();
        $reservation->setUser($user);
        $reservation->setStadium($stadium);
        $reservation->setDate($date);
        $reservation->setStartTime($startTime);
        $reservation->setEndTime($endTime);
        dump($reservation);
        $entityManager->persist($reservation);
        $entityManager->flush();
        return $this->render('payment/paymentSuccessfull.html.twig', [
            'controller_name' => 'PaymentController',
            'stadium' => $stadium
        ]);
    }
}
