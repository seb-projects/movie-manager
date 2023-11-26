<?php

namespace App\Transformer;

use App\Model\Api\GetResultsCollectionInterface;
use App\Model\Api\Movie\Result;
use App\Model\Movie;
use App\Service\RatingRetrieval;
use App\Validator\ImageExists;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Asset\Packages;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class MovieApiToMovieCollectionTransformer implements CustomTransformerInterface
{
    private ValidatorInterface $validator;
    private Packages $assetPackage;
    private RatingRetrieval $ratingRetrieval;

    public function __construct(
        ValidatorInterface $validator,
        Packages $assetPackage,
        RatingRetrieval $ratingRetrieval
    ) {
        $this->validator = $validator;
        $this->assetPackage = $assetPackage;
        $this->ratingRetrieval = $ratingRetrieval;
    }

    public function transform(GetResultsCollectionInterface $responseApi): ArrayCollection
    {
        $movieCollection = new ArrayCollection();

        /* @var $result Result */
        foreach ($responseApi->getResults() as $result) {
            $movie = (new Movie())
                ->setId($result->getId())
                ->setTitle($result->getTitleText()->getText())
                ->setReleaseYear($result->getReleaseYear()->getYear())
                ->setUrlImage($result->getPrimaryImage()->getUrl());

            $errors = $this->validator->validate($movie);

            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    if (ImageExists::IMAGE_NOT_FOUND == $error->getMessage()) {
                        $movie->setUrlImage($this->assetPackage->getUrl(Movie::URL_IMAGE_DEFAULT_VALUE));
                    }
                }
            }

            $ratingApi = $this->ratingRetrieval->find($movie->getId());
            $movie->setAverageRating($ratingApi->getResults()->getAverageRating())
                ->setNumVotes($ratingApi->getResults()->getNumVotes());

            $movieCollection->add($movie);
        }

        return $movieCollection;
    }
}
