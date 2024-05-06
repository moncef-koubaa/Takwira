<?php

namespace App\Controller;

use App\Entity\Stadium;
use App\Form\StadiumType;
use App\Service\ImageUploader;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use SebastianBergmann\CodeCoverage\Report\PHP;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use function Symfony\Component\String\s;

use Symfony\Component\HttpFoundation\File\UploadedFile;


class AddStadiumController extends AbstractController
{
    private function validateTimeFormat(DateTime $time): bool
    {
        return $time->format('H:00') === $time->format('H:i');
    }

    private function validateTime(DateTime $closingTime, DateTime $openingTime): bool
    {
        if (!$this->validateTimeFormat($closingTime) || !$this->validateTimeFormat($openingTime)) {
            $this->addFlash('timeError', 'Time format should be HH:00 !');
            return false;
        }
        if ($closingTime < $openingTime) {
            $this->addFlash('timeError', 'Closing time should be after opening time !');
            return false;
        }
        return true;
    }

    private function validateImages($images): bool
    {
        if (count($images) > 4) {
            $this->addFlash('imageError', 'You can only upload MAX 4 images');
            return false;
        }
        return true;
    }

    private function validateForm($form): bool
    {
        return $form->isSubmitted() && $form->isValid() &&
            $this->validateTime($form->get('closingTime')->getData(), $form->get('openingTime')->getData()) &&
            $this->validateImages($form->get('stadiumImages')->getData());
    }

    #[Route('/addStadium', name: 'app_add_stadium')]
    public function index(Request $request): Response
    {
        dump($request);
        return $this->render('add_stadium/index.html.twig', []);
    }

    #[Route('/addStadiumTest/{id?0}', name: 'app_add_stadium_test')]
    public function addStadiumTest(
        Request $request,
        ImageUploader $uploader,
        EntityManagerInterface $entityManager,
        Stadium $stadium = null
    ): Response
    {
        if (!$stadium) {
            $stadium = new Stadium();
        }
        $form = $this->createForm(StadiumType::class, $stadium);
        $form->remove('owner');
        $form->remove('ownerId');
        $form->handleRequest($request);

        if ($this->validateForm($form)) {
                $images = $form->get('stadiumImages')->getData();
            for ($i = 0; $i < count($images); $i++) {
                $stadium->addImage($uploader->upload($images[$i], $i));
            }
            $stadium->setOwner($this->getUser());
            $entityManager->persist($stadium);
            $entityManager->flush();
            return $this->redirectToRoute('app_monitor_stadium', ['stadiumId' => $stadium->getId()]);
        }

        return $this->render('add_stadium/addStadiumTest.html.twig', [
            'form' => $form->createView(),
            'stadiumImages' => $stadium->getImages()
        ]);
    }
}
