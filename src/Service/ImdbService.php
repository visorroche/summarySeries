<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\DTO\TMDB\TmdbSearchTvDTO;
use App\DTO\TMDB\TmdbSeasonDTO;
use App\Entity\Serie;

class ImdbService
{
    private $route = "https://api.themoviedb.org/3";
    private $client;
    private $api_key;

    public function __construct(HttpClientInterface $client, string $api_key)
    {
        $this->client = $client;
        $this->api_key = $api_key;
    }
    
    public function getSerieById($id): array
    {
        $url = $this->route.'/tv/'.$id.'?api_key='.$this->api_key;
        $response = $this->client->request('GET', $url);
        $data = $response->toArray();
        return $data;
    }

    public function getSeasons($id): array
    {
        $serie = $this->getSerieById($id);
        foreach ($serie['seasons'] as $season) {
            $seasons[] = new TmdbSeasonDTO($season);
        }
        return $seasons;
    }

    public function getSerieByName($name): ?TmdbSearchTvDTO
    {
        $url = $this->route.'/search/tv?api_key='.$this->api_key.'&query='.$name;
        $response = $this->client->request('GET', $url);
        $data = $response->toArray();
        if (empty($data['results'])) {
            return null;
        }
        $Tmdb = new TmdbSearchTvDTO($data['results'][0]);
        return $Tmdb;
    }
    public function getCharacters($id): array
    {
        $url = $this->route.'/tv/'.$id.'/credits?api_key='.$this->api_key;
        $response = $this->client->request('GET', $url);
        $data = $response->toArray();
        return $data['results'][0];
    }
    public function getImagemByPath($path): string
    {
        return 'https://image.tmdb.org/t/p/w500/'.$path;
    }
    public function getAllCategorys(): array 
    {
        $url = $this->route.'/genre/tv/list?api_key='.$this->api_key;
        $response = $this->client->request('GET', $url);
        $data = $response->toArray();
        return $data['genres'];
    }
}
