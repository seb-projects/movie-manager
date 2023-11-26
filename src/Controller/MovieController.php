<?php

namespace App\Controller;

use App\Event\MovieEvent;
use App\Event\MovieFilterEvent;
use App\Event\SearchKeywordEvent;
use App\Event\SearchTitleEvent;
use App\Form\MovieFilterType;
use App\Model\MovieFilter;
use App\Transformer\MovieApiToMovieCollectionTransformer;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class MovieController extends AbstractController
{
    #[Route('/movies', name: 'app_movie')]
    public function index(
        Request $request,
        MovieApiToMovieCollectionTransformer $moviesTransformer,
        EventDispatcherInterface $eventDispatcher,
        LoggerInterface $logger
    ): Response {
        $movieFilter = (new MovieFilter())
            ->setYear(MovieFilter::YEAR_DEFAULT_VALUE)
            ->setTitleType(MovieFilter::TYPE_DEFAULT_VALUE)
            ->setList(MovieFilter::LIST_DEFAULT_VALUE)
            ->setGenre(MovieFilter::GENRE_DEFAULT_VALUE)
            ->setPage(MovieFilter::PAGE_DEFAULT_VALUE);

        $form = $this->createForm(MovieFilterType::class, $movieFilter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $logger->info('Form is submitted and is valid.');

            if (!empty($movieFilter->getTitle())) {
                $event = new SearchTitleEvent($movieFilter);
            } elseif (!empty($movieFilter->getKeyword())) {
                $event = new SearchKeywordEvent($movieFilter);
            } else {
                $event = new MovieFilterEvent($movieFilter);
            }
        } else {
            $event = new MovieEvent($movieFilter);
        }

        $logger->debug('Movie filter', ['movieFilter' => $movieFilter]);

        $eventDispatcher->dispatch($event, $event::NAME);
        $movieCollection = $moviesTransformer->transform($event->getMovies());

        $logger->debug('Movie collection', ['movieCollection' => $movieCollection]);

        return $this->render('movie_manager/index.html.twig', [
            'movies' => $movieCollection,
            'form' => $form->createView(),
        ]);
    }
}
