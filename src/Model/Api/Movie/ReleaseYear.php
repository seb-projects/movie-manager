<?php

namespace App\Model\Api\Movie;

class ReleaseYear
{
    private ?int $year = null;

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): ReleaseYear
    {
        $this->year = $year;

        return $this;
    }
}
