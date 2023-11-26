<?php

namespace App\Transformer;

use App\Model\Api\GetResultsCollectionInterface;
use Doctrine\Common\Collections\ArrayCollection;

interface CustomTransformerInterface
{
    public function transform(GetResultsCollectionInterface $responseApi): ArrayCollection;
}
