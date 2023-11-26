<?php

namespace App\Event;

use App\Model\Api\Movie\MovieApi;
use App\Model\MovieFilter;

interface MovieFilterEventInterface
{
    public function getMovieFilter(): MovieFilter;

    public function getMovies(): MovieApi;

    public function setMovies(MovieApi $movies): MovieFilterEventInterface;
}
