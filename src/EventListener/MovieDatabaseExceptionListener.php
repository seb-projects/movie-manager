<?php

namespace App\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Twig\Environment;

final class MovieDatabaseExceptionListener
{
    public const URL_MOVIE_DATABASE_ERROR = "L'url pour l'API Movie Database est incorrecte.";
    public const API_TOKEN_MOVIE_DATABASE_ERROR = "Le token pour l'API Movie Database est incorrect.";
    private Environment $templating;
    private LoggerInterface $logger;

    public function __construct(Environment $twig, LoggerInterface $logger)
    {
        $this->templating = $twig;
        $this->logger = $logger;
    }

    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof TransportException) {
            $message = self::URL_MOVIE_DATABASE_ERROR;
        } elseif ($exception instanceof ClientException) {
            $message = self::API_TOKEN_MOVIE_DATABASE_ERROR;
        } else {
            return;
        }
        $this->logger->error($message, ['message' => $exception->getMessage(), 'code' => $exception->getCode()]);
        $content = $this->templating->render('movie_manager/error.html.twig', [
            'error' => $message,
        ]);

        $response = new Response($content);

        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $event->setResponse($response);
    }
}
