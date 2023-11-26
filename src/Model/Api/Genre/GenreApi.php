<?php

namespace App\Model\Api\Genre;

use App\Model\Api\ResponseApiInterface;

class GenreApi implements ResponseApiInterface
{
    private array $results;

    public function getResults(): array
    {
        return $this->results;
    }

    public function setResults(array $results): GenreApi
    {
        $this->results = $results;

        return $this;
    }
}
