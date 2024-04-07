<?php

namespace App\DTO\TMDB;

class TmdbSearchTvDTO
{
    public ?bool $adult;
    public ?string $backdropPath;
    public ?array $genreIds;
    public ?int $id;
    public ?array $originCountry;
    public ?string $originalLanguage;
    public ?string $originalName;
    public ?string $overview;
    public ?float $popularity;
    public ?string $posterPath;
    public ?string $firstAirDate;
    public ?string $name;
    public ?float $voteAverage;
    public ?int $voteCount;

    public function __construct(
        $dados
    ) {
        $this->adult = $dados['adult'];
        $this->backdropPath = $dados['backdrop_path'];
        $this->genreIds = $dados['genre_ids'];
        $this->id = $dados['id'];
        $this->originCountry = $dados['origin_country'];
        $this->originalLanguage = $dados['original_language'];
        $this->originalName = $dados['original_name'];
        $this->overview = $dados['overview'];
        $this->popularity = $dados['popularity'];
        $this->posterPath = $dados['poster_path'];
        $this->firstAirDate = $dados['first_air_date'];
        $this->name = $dados['name'];
        $this->voteAverage = $dados['vote_average'];
        $this->voteCount = $dados['vote_count'];
    }

    // Add getters and setters for each property
    // ...
}