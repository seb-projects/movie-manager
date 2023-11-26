<?php

namespace App\Client;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class MoviesDatabaseClient
{
    use MoviesDatabaseClientTrait;

    public const GET_TITLES = '/titles';
    public const SEARCH_TITLES = '/titles/search/title/%s';
    public const SEARCH_KEYWORD = '/titles/search/keyword/%s';
    public const GET_TITLE_GENRES = '/titles/utils/genres';
    public const GET_TITLE_LISTS = '/titles/utils/lists';
    public const GET_RATING = '/titles/%s/ratings';
    public const API_KEY_HEADER_NAME = 'X-RapidAPI-Key';
    public const MODE_GET_TITLES = 'get_titles';
    public const MODE_SEARCH_TITLES = 'search_titles';
    public const MODE_SEARCH_KEYWORD = 'search_keyword';
    public const TITLES_MAPPING_API = [
        self::MODE_GET_TITLES => [
            'resource' => self::GET_TITLES,
            'path_variable' => null,
        ],
        self::MODE_SEARCH_TITLES => [
            'resource' => self::SEARCH_TITLES,
            'path_variable' => 'title',
        ],
        self::MODE_SEARCH_KEYWORD => [
            'resource' => self::SEARCH_KEYWORD,
            'path_variable' => 'keyword',
        ],
    ];
    public const TITLES_DEFAULT_MODE = self::MODE_GET_TITLES;

    private string $movieDatabaseUrl;
    private string $movieDatabaseApiKey;

    public function __construct(
        private HttpClientInterface $client,
        string $movieDatabaseUrl,
        string $movieDatabaseApiKey
    ) {
        $this->movieDatabaseUrl = $movieDatabaseUrl;
        $this->movieDatabaseApiKey = $movieDatabaseApiKey;
    }

    public function getTitles(array $query = null, string $mode = null): string
    {
        $configuration = self::TITLES_MAPPING_API[self::TITLES_DEFAULT_MODE];
        if (!empty(self::TITLES_MAPPING_API[$mode])) {
            $configuration = self::TITLES_MAPPING_API[$mode];
        }

        $resource = $configuration['resource'];
        if (null !== $configuration['path_variable']) {
            $pathVariable = \rawurlencode($query[$configuration['path_variable']]);
            $resource = \sprintf($configuration['resource'], $pathVariable);
            unset($query[$configuration['path_variable']]);
        }

        $response = $this->client->request(
            'GET',
            \sprintf('%s%s', $this->movieDatabaseUrl, $resource),
            [
                'query' => $query,
                'headers' => $this->getHeaders(),
            ]
        );

        return $response->getContent();
    }

    public function getRating(string $id): string
    {
        $resource = \sprintf(self::GET_RATING, $id);
        $response = $this->client->request(
            'GET',
            \sprintf('%s%s', $this->movieDatabaseUrl, $resource),
            ['headers' => $this->getHeaders()]
        );

        return $response->getContent();
    }

    public function getTitleGenres(): string
    {
        return $this->getInfos(self::GET_TITLE_GENRES);
    }

    public function getTitleLists(): string
    {
        return $this->getInfos(self::GET_TITLE_LISTS);
    }

    private function getInfos(string $category): string
    {
        $response = $this->client->request(
            'GET',
            \sprintf('%s%s', $this->movieDatabaseUrl, $category),
            ['headers' => $this->getHeaders()]
        );

        return $response->getContent();
    }
}
