<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

final class SearchKeywordEvent extends Event implements MovieFilterEventInterface
{
    use MovieFilterEventTrait;
    public const NAME = 'search.keyword.event';
}
