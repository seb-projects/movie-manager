<?php

namespace App\Model\Api\Rating;

use App\Model\Api\ResponseApiInterface;

class RatingApi implements ResponseApiInterface
{
    private Results $results;

    public function getResults(): Results
    {
        return $this->results;
    }

    public function setResults(Results $results): RatingApi
    {
        $this->results = $results;

        return $this;
    }
}
