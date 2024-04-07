<?php

namespace App\DTO\TMDB;

class TmdbSeasonDTO
{
    public ?string $airDate;
    public ?int $episodeCount;
    public ?int $id;
    public ?string $name;
    public ?string $overview;
    public ?string $posterPath;
    public ?int $seasonNumber;
    public ?float $voteAverage;

    public function __construct(
        $dados
    ) {
        $this->airDate = $dados['air_date'];
        $this->episodeCount = $dados['episode_count'];
        $this->id = $dados['id'];
        $this->name = $dados['name'];
        $this->overview = $dados['overview'];
        $this->posterPath = $dados['poster_path'];
        $this->seasonNumber = $dados['season_number'];
        $this->voteAverage = $dados['vote_average'];
    }

    // Add getters and setters for each property

    // Add any additional methods or functionality as needed
}