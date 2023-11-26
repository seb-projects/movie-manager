<?php

namespace App\Event;

use App\Model\Api\Movie\MovieApi;
use App\Model\MovieFilter;

trait MovieFilterEventTrait
{
    protected MovieFilter $movieFilter;
    protected MovieApi $movies;

    public function __construct(MovieFilter $movieFilter)
    {
        $this->movieFilter = $movieFilter;
    }

    public function getMovieFilter(): MovieFilter
    {
        return $this->movieFilter;
    }

    public function getMovies(): MovieApi
    {
        return $this->movies;
    }

    public function setMovies(MovieApi $movies): self
    {
        $this->movies = $movies;

        return $this;
    }
}
