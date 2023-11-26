<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

final class MovieEvent extends Event implements MovieFilterEventInterface
{
    use MovieFilterEventTrait;
    public const NAME = 'movie.event';
}
