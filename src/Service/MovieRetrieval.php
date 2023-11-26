<?php

namespace App\Service;

use App\Client\MoviesDatabaseClient;
use App\Model\Api\Movie\MovieApi;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

final class MovieRetrieval implements RetrievalInterface
{
    private MoviesDatabaseClient $moviesDatabaseClient;

    public function __construct(MoviesDatabaseClient $moviesDatabaseClient)
    {
        $this->moviesDatabaseClient = $moviesDatabaseClient;
    }

    public function findBy(array $query = null, string $mode = null): MovieApi
    {
        $titlesContent = $this->moviesDatabaseClient->getTitles($query, $mode);

        $encoders = [new JsonEncoder()];
        $normalizers = [
            new ObjectNormalizer(
                null,
                null,
                null,
                new ReflectionExtractor()
            ),
            new ArrayDenormalizer(),
        ];
        $serializer = new Serializer($normalizers, $encoders);

        return $serializer->deserialize($titlesContent, MovieApi::class, 'json');
    }
}
