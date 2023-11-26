<?php

namespace App\Model\Api\List;

use App\Model\Api\ResponseApiInterface;

class ListApi implements ResponseApiInterface
{
    private array $results;

    public function getResults(): array
    {
        return $this->results;
    }

    public function setResults(array $results): ListApi
    {
        $this->results = $results;

        return $this;
    }
}
