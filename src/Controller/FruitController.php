<?php

namespace App\Controller;

use App\Service\FruitService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FruitController extends AbstractController
{
    /**
     * @Route("/", name="fruits")
     * @param Request $request
     * @param FruitService $fruitService
     * @return Response
     */
    public function index(Request $request, FruitService $fruitService): Response
    {
        $fruits = $fruitService->findAll();
        $fields = ['id','genus','name','family','order', 'nutritions'];
        return $this->render('fruits.html.twig', ['fruits' => $fruits,'fields' => $fields]);
    }

    /**
     * @Route("/add-favourite", methods="POST")
     * @param Request $request
     * @param FruitService $fruitService
     * @return JsonResponse
     */
    public function addFavourite(Request $request, FruitService $fruitService): JsonResponse
    {
        return $fruitService->addToFavourites($request);
    }

    /**
     * @Route("/favourites", name="favourites")
     * @param Request $request
     * @param FruitService $fruitService
     * @return Response
     */
    public function favourites(Request $request, FruitService $fruitService): Response
    {
        //$request->getSession()->set('favourites',[]);
        $fruits = $fruitService->getFavourites($request);
        $fields = ['id','genus','name','family','order','nutritions'];
        return $this->render('favourites.html.twig', ['fruits' => $fruits,'fields' => $fields]);
    }
}
