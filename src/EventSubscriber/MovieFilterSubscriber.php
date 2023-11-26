<?php

namespace App\EventSubscriber;

use App\Client\MoviesDatabaseClient;
use App\Event\MovieEvent;
use App\Event\MovieFilterEvent;
use App\Event\MovieFilterEventInterface;
use App\Event\SearchKeywordEvent;
use App\Event\SearchTitleEvent;
use App\Service\MovieRetrieval;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class MovieFilterSubscriber implements EventSubscriberInterface
{
    private MovieRetrieval $movieRetrieval;
    private LoggerInterface $logger;

    public function __construct(MovieRetrieval $movieRetrieval, LoggerInterface $logger)
    {
        $this->movieRetrieval = $movieRetrieval;
        $this->logger = $logger;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            MovieEvent::NAME => 'onMovieEvent',
            MovieFilterEvent::NAME => 'onMovieFilterEvent',
            SearchTitleEvent::NAME => 'onSearchTitleEvent',
            SearchKeywordEvent::NAME => 'onSearchKeywordEvent',
        ];
    }

    public function onMovieEvent(MovieFilterEventInterface $event): void
    {
        $this->logger->info(\sprintf('Logger "%s" is triggered.', MovieEvent::NAME));
        $this->retrieveMovies($event, MoviesDatabaseClient::MODE_GET_TITLES);
    }

    public function onMovieFilterEvent(MovieFilterEventInterface $event): void
    {
        $this->logger->info(\sprintf('Logger "%s" is triggered.', MovieFilterEvent::NAME));
        $this->retrieveMovies($event, MoviesDatabaseClient::MODE_GET_TITLES);
    }

    public function onSearchTitleEvent(MovieFilterEventInterface $event): void
    {
        $this->logger->info(\sprintf('Logger "%s" is triggered.', SearchKeywordEvent::NAME));
        $event->getMovieFilter()->setKeyword(null);
        $this->retrieveMovies($event, MoviesDatabaseClient::MODE_SEARCH_TITLES);
    }

    public function onSearchKeywordEvent(MovieFilterEventInterface $event): void
    {
        $this->logger->info(\sprintf('Logger "%s" is triggered.', SearchTitleEvent::NAME));
        $event->getMovieFilter()->setTitle(null);
        $this->retrieveMovies($event, MoviesDatabaseClient::MODE_SEARCH_KEYWORD);
    }

    private function retrieveMovies(MovieFilterEventInterface $event, string $mode): void
    {
        $movies = $this->movieRetrieval->findBy($event->getMovieFilter()->toArray(), $mode);
        $event->setMovies($movies);
    }
}
