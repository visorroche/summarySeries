<?php

namespace App\Controller;

use App\Entity\Season;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SeriesRepository;
use App\Entity\Serie;
use App\Repository\CategorysRepository;
use App\Repository\SeasonsRepository;
use App\Service\Domain\SummaryService;
use App\Service\ImdbService;

class SeriesController extends AbstractController
{
    private $seriesRepository;
    private $seasonsRepository;
    private $categorysRepository;
    private $imdbService;
    private $gptService;

    public function __construct(SeriesRepository $seriesRepository, 
                                SeasonsRepository $seasonsRepository,
                                CategorysRepository $categorysRepository,
                                ImdbService $imdbService,
                                SummaryService $gptService)
    {
        $this->seriesRepository = $seriesRepository;
        $this->seasonsRepository = $seasonsRepository;
        $this->categorysRepository = $categorysRepository;
        $this->imdbService = $imdbService;
        $this->gptService = $gptService;
    }

    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $session = $request->getSession();
        return $this->render('series/index.html.twig', []);
    }

    /*
    *   Receives a string 'serie' with the name of a serie
    */
    #[Route('/serie', name: 'app_add_serie', methods: ['POST'])]
    public function addSerie(Request $request): Response
    {
        $serieName = $request->request->get('serie');

        // We try to search in our database before searching in TMDB
        $serieDB = $this->seriesRepository->findByName($serieName);      
        if ($serieDB) {
            return $this->redirectToRoute('app_serie', ['slug' => $serieDB->getSlug()]);
        }
        
        // If we don't find it in our database, we search in TMDB
        $tmdb = $this->imdbService->getSerieByName($serieName);
        
        // If we don't find it in TMDB, we return an error
        if (!$tmdb) {
            $this->addFlash('warning', 'Serie not found');
            return $this->redirectToRoute('app_chatbot');
        }
        
        $serie = new Serie($tmdb->name);
        $serie->setTmdbId($tmdb->id);
        $serie->setImbdScore($tmdb->voteAverage);
        $serie->setSynopsis($tmdb->overview);
        $catsString = $this->categorysRepository->getCategorysNames($tmdb->genreIds);
        $serie->setCategorys($catsString);
        $serie->setImage($this->imdbService->getImagemByPath($tmdb->posterPath));

        // We add the serie to our database
        $this->seriesRepository->add($serie,true);

        // Get all the seasons of the serie
        $seasons = $this->imdbService->getSeasons($serie->getTmdbId());
        foreach ($seasons as $season) {
            $newSeason = new Season($serie, $season->seasonNumber);
            $newSeason->setName($season->name);
            $newSeason->setSynopsis($season->overview);
            $newSeason->setImdbScore($season->voteAverage);
            $newSeason->setImage($this->imdbService->getImagemByPath($season->posterPath));
            $this->seasonsRepository->add($newSeason);
        }

        return $this->redirectToRoute('app_serie', ['slug' => $serie->getSlug()]);
    }

    #[Route('/serie/{slug}', name: 'app_serie', methods: ['GET'])]
    public function serie($slug): Response
    {
        $serie = $this->seriesRepository->findBySlug($slug);
        
        return $this->render('series/serie.html.twig', [
            'serie' => $serie,
        ]);
    }

    #[Route('/serie/{slug}/summary', name: 'app_season_summary', methods: ['GET'])]
    public function season(Request $request, $slug): Response
    {
        $seasonId = $request->query->get('season');
        $serie = $this->seriesRepository->findBySlug($slug);
        $season = $this->seasonsRepository->find($seasonId);
        
        if(strlen($season->getSummary())<10){
            //TO DO: Implement thread conversation and asked for each epsode summary
            //TO DO: Save summarys in epsodes, no in season
            $summary = $this->gptService->getSummary($serie->getName(), $season->getNumber());
            $season->setSummary($summary);
            $this->seasonsRepository->update($season);
        } 
        
        return $this->render('series/temporada.html.twig', [
            'serie' => $serie,
            'season' => $season
        ]);
    }

}
