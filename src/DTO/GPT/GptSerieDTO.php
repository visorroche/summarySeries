<?php

namespace App\DTO\GPT;

/**
 * Class SerieGptDTO
 * Data Transfer Object for SerieGpt
 * 
 * { "nome": "LOST",
 *   "sinopse": "LOST é uma série...",
 *   "categoria": ["Aventura", "Mistério"],
 *   "notaIMDB": 8.3,
 *   "capaSerie": "https://www.themoviedb.org/tv/4607-lost",
 *   "temporadas": [
 *   { "numero": 1, 
 *     "numeroDeEpisodios": 25, 
 *     "resumo": "A primeira temporada...",
 *     "notaIMDB": 8.4,
 *     "capaTemporada": "https://www.themoviedb.org/tv/4607-lost/season/1" }
 *    ]}
 */
class GptSerieDTO
{
    private $nome;
    private $sinopse;
    private $categoria;
    private $notaIMDB;
    private $capaSerie;
    private $temporadas;

    public function __construct($nome, $sinopse, $categoria, $notaIMDB, $capaSerie, $temporadas)
    {
        $this->nome = $nome;
        $this->sinopse = $sinopse;
        $this->categoria = $categoria;
        $this->notaIMDB = $notaIMDB;
        $this->capaSerie = $capaSerie;
        $this->temporadas = $temporadas;
    }

    // Getters and setters for each property

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getSinopse()
    {
        return $this->sinopse;
    }

    public function setSinopse($sinopse)
    {
        $this->sinopse = $sinopse;
    }

    public function getCategoria()
    {
        return $this->categoria;
    }

    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
    }

    public function getNotaIMDB()
    {
        return $this->notaIMDB;
    }

    public function setNotaIMDB($notaIMDB)
    {
        $this->notaIMDB = $notaIMDB;
    }

    public function getCapaSerie()
    {
        return $this->capaSerie;
    }

    public function setCapaSerie($capaSerie)
    {
        $this->capaSerie = $capaSerie;
    }

    public function getTemporadas()
    {
        return $this->temporadas;
    }

    public function setTemporadas($temporadas)
    {
        $this->temporadas = $temporadas;
    }
}