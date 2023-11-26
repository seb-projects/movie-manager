<?php

namespace App\Model\Api\Rating;

class Results
{
    private ?float $averageRating = null;
    private ?int $numVotes = null;

    public function getAverageRating(): ?float
    {
        return $this->averageRating;
    }

    public function setAverageRating(?float $averageRating): Results
    {
        $this->averageRating = $averageRating;

        return $this;
    }

    public function getNumVotes(): ?int
    {
        return $this->numVotes;
    }

    public function setNumVotes(?int $numVotes): Results
    {
        $this->numVotes = $numVotes;

        return $this;
    }
}
