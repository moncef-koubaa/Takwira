<?php

namespace App\Controller;

use App\Entity\Stadium;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OwnerStadiumPageController extends AbstractController
{
    #[Route('/stadiumOwner', name: 'app_owner_stadium_page')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $user = $this->getUser();

        if (!$this->isGranted('ROLE_OWNER')) {
            // Redirect the user to the home route
            return $this->redirectToRoute('app_home');
        }

        $repository = $doctrine->getRepository(Stadium::class);
        $stadiums = $repository->findBy(['ownerId' => $user->getId()]);
        return $this->render('owner_stadium_page/index.html.twig', [
            'stadiums' => $stadiums,
        ]);
    }

    #[Route('/stadiumOwner/deleteStadium', name: 'delete_stadium', methods: ['POST'])]
    public function deleteStadium(Request $request, ManagerRegistry $doctrine): JsonResponse
    {
        // Retrieve the stadium ID from the request body
        $requestData = json_decode($request->getContent(), true);
        $id = $requestData['stadiumId'] ?? null; // Assuming the stadium ID is sent as 'stadiumId'


        // Fetch the stadium entity
        $entityManager = $doctrine->getManager();
        $stadium = $entityManager->getRepository(Stadium::class)->find($id);

        // Check if the stadium exists
        if (!$stadium) {
            return new JsonResponse(['error' => 'Stadium not found'], 404);
        }

        // Check if the current user has permission to delete the stadium
        $currentUser = $this->getUser();
        if ($currentUser->getId() !== $stadium->getOwnerId()) {
            return new JsonResponse(['error' => 'You do not have permission to delete this stadium'], 403);
        }

        try {
            // Remove the stadium
            $entityManager->remove($stadium);
            $entityManager->flush();

            // Return success response
            return new JsonResponse(['message' => 'Stadium deleted successfully'], 200);
        } catch (\Exception $e) {
            // Return error response
            return new JsonResponse(['error' => 'Failed to delete stadium: ' . $e->getMessage()], 500);
        }
    }
}
