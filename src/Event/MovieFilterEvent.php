<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

final class MovieFilterEvent extends Event implements MovieFilterEventInterface
{
    use MovieFilterEventTrait;
    public const NAME = 'movie.filter.event';
}
