<?php

namespace App\Controller;

use Pagerfanta\Pagerfanta;
use App\Repository\PlanetRepository;
use App\Repository\VoyageRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function homepage(
        VoyageRepository $voyageRepository,
        PlanetRepository $planetRepository,
        #[MapQueryParameter] int $page = 1,
        #[MapQueryParameter('query')] string $query = null,
        #[MapQueryParameter('planets', \FILTER_VALIDATE_INT)] array $searchPlanets = [],
        #[MapQueryParameter] string $sort = 'leaveAt',
        #[MapQueryParameter] string $sortDirection = 'ASC',
    ): Response
    {
        $validSorts = ['purpose', 'leaveAt','planet'];
        $sort = in_array($sort, $validSorts) ? $sort : 'leaveAt';
        $pager = Pagerfanta::createForCurrentPageWithMaxPerPage(
            new QueryAdapter($voyageRepository->findBySearchQueryBuilder($query, $searchPlanets, $sort, $sortDirection)),
            $page,
            10
        );
        $voyages = $voyageRepository->findBySearch($query, $searchPlanets);

        return $this->render('main/homepage.html.twig', [
            'voyages' => $pager,
            'planets' => $planetRepository->findAll(),
            'searchPlanets' => $searchPlanets,
            'sort' => $sort,
            'sortDirection' => $sortDirection,
        ]);
    }
}
