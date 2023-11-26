<?php

namespace App\Service;

use App\Client\MoviesDatabaseClient;
use App\Model\Api\List\ListApi;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

final class ListRetrieval implements RetrievalInterface
{
    public const LISTS_EXCLUDED = ['most_pop_series', 'top_rated_series_250', 'titles'];
    public const LISTS_EMPTY = ['most_pop_movies', 'top_rated_250'];

    private MoviesDatabaseClient $moviesDatabaseClient;

    public function __construct(MoviesDatabaseClient $moviesDatabaseClient)
    {
        $this->moviesDatabaseClient = $moviesDatabaseClient;
    }

    public function findAll(): array
    {
        $listsContents = $this->moviesDatabaseClient->getTitleLists();

        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        /* @var ListApi $listsContents */
        $lists = $serializer->deserialize($listsContents, ListApi::class, 'json');

        if (!empty($lists->getResults())) {
            $results = \array_filter($lists->getResults());
            $results = \array_diff($results, self::LISTS_EXCLUDED);

            return \array_diff($results, self::LISTS_EMPTY);
        }

        return [];
    }
}
