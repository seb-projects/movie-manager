<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

final class SearchTitleEvent extends Event implements MovieFilterEventInterface
{
    use MovieFilterEventTrait;
    public const NAME = 'search.title.event';
}
