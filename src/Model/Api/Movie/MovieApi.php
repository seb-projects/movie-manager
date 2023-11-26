<?php

namespace App\Model\Api\Movie;

use App\Model\Api\GetResultsCollectionInterface;
use App\Model\Api\ResponseApiInterface;
use Doctrine\Common\Collections\ArrayCollection;

class MovieApi implements ResponseApiInterface, GetResultsCollectionInterface
{
    private string $page;
    private ArrayCollection $results;

    public function __construct()
    {
        $this->results = new ArrayCollection();
    }

    public function getPage(): string
    {
        return $this->page;
    }

    public function setPage(string $page): MovieApi
    {
        $this->page = $page;

        return $this;
    }

    public function getResults(): ArrayCollection
    {
        return $this->results;
    }

    public function addResult(Result $result): MovieApi
    {
        $this->results->add($result);

        return $this;
    }

    public function removeResult(Result $result): MovieApi
    {
        $this->results->removeElement($result);

        return $this;
    }
}
