<?php

namespace App\Service;

use App\Client\MoviesDatabaseClient;
use App\Model\Api\Rating\RatingApi;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

final class RatingRetrieval implements RetrievalInterface
{
    private MoviesDatabaseClient $moviesDatabaseClient;

    public function __construct(MoviesDatabaseClient $moviesDatabaseClient)
    {
        $this->moviesDatabaseClient = $moviesDatabaseClient;
    }

    public function find(string $id): RatingApi
    {
        $rating = $this->moviesDatabaseClient->getRating($id);

        $encoders = [new JsonEncoder()];
        $normalizers = [
            new ObjectNormalizer(
                null,
                null,
                null,
                new ReflectionExtractor()
            ),
        ];
        $serializer = new Serializer($normalizers, $encoders);

        return $serializer->deserialize($rating, RatingApi::class, 'json');
    }
}
