<?php

namespace App\Service;

use App\Client\MoviesDatabaseClient;
use App\Model\Api\Genre\GenreApi;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

final class GenreRetrieval implements RetrievalInterface
{
    public const GENRES_EXCLUDED = ['Adult', 'Game-Show', 'Music', 'Musical', 'News', 'Reality-TV', 'Sport', 'Short'];
    private MoviesDatabaseClient $moviesDatabaseClient;

    public function __construct(MoviesDatabaseClient $moviesDatabaseClient)
    {
        $this->moviesDatabaseClient = $moviesDatabaseClient;
    }

    public function findAll(): array
    {
        $genresContent = $this->moviesDatabaseClient->getTitleGenres();

        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        /* @var GenreApi $genres */
        $genres = $serializer->deserialize($genresContent, GenreApi::class, 'json');

        if (!empty($genres->getResults())) {
            $results = \array_filter($genres->getResults());

            return \array_diff($results, self::GENRES_EXCLUDED);
        }

        return [];
    }
}
