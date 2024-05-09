<?php

namespace App\Controller;

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Stadium;
use Doctrine\Persistence\ManagerRegistry;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use function Webmozart\Assert\Tests\StaticAnalysis\integer;



class HomeController extends AbstractController
{
    public function stadiumbystate(Request $request, ManagerRegistry $doctrine, $min, $max, $state, $date, $name, $pageNumber): Response
    {
        $repository = $doctrine->getRepository(Stadium::class);
        $imageRepository = $doctrine->getRepository(Image::class);
        $stadiums = $repository->print($min, $max, $state, $date, $name, $pageNumber);
        $queryParams = $request->query->all();
        $images=$imageRepository->findAll();

        $queryParams = array_merge($queryParams, [
            'state' => $state,
            'priceMin' => $min,
            'priceMax' => $max,
            'date' => $date,
            'name' => $name
        ]);
//        var_dump(ceil($stadiums['totalResults'] / $stadiums['pageSize']),);
//            die();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'stadiums' => $stadiums['results'],
            'images' => $images,
            'pageNumber' => $stadiums['currentPage'],
            'totalPages' => ceil($stadiums['totalResults'] / 6),
            'queryParams' => $queryParams
        ]);
    }


    public function FilterFormSubmission(Request $request, ManagerRegistry $doctrine,$pageNumber=1): Response
    {
        $state = $request->request->get('state');
        $priceMin = $request->request->get('priceMin');
        $priceMin =50+intval($priceMin);
        $priceMax = $request->request->get('priceMax');
        $priceMax =50+intval($priceMax);
        $date = $request->request->get('date');
        $name = $request->request->get('name');

        return $this->stadiumbystate($request,$doctrine,$priceMin,$priceMax,$state,$date,$name,$pageNumber);

    }
    #[Route('/home', name: 'app_home')]
    public function index(ManagerRegistry $doctrine,Request $request): Response
    {
        {
            $pageNumber = $request->query->getInt('page', 1);
            $state = $request->query->get('state', null);
            $priceMin = $request->query->get('priceMin', 50);
            $priceMax = $request->query->get('priceMax', 150);
            $date = $request->query->get('date', "");
            $name = $request->query->get('name', "");
            return $this->stadiumbystate($request,$doctrine,$priceMin,$priceMax,$state,$date,$name,$pageNumber);
        }
    }
    #[Route('/test', name: 'test   ')]
    public function test(ManagerRegistry $doctrine,Request $request): Response
    {

            return ($this->render('home/test.html.twig'));
        }
}
