<?php

namespace App\Model\Api;

use App\Model\Api\Movie\Result;
use Doctrine\Common\Collections\ArrayCollection;

interface GetResultsCollectionInterface
{
    public function getResults(): ArrayCollection;

    public function addResult(Result $result): ResponseApiInterface;

    public function removeResult(Result $result): ResponseApiInterface;
}
