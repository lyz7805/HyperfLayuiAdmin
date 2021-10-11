<?php

declare(strict_types=1);

namespace App\Utils;

use Hyperf\Utils\ApplicationContext;
use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * Event
 */
class Event
{
    protected static function eventDispatcher(): EventDispatcherInterface
    {
        return ApplicationContext::getContainer()->get(EventDispatcherInterface::class);
    }

    /**
     * Provide all relevant listeners with an event to process.
     *
     * @param object $event
     *   The object to process.
     *
     * @return object
     *   The Event that was passed, now modified by listeners.
     */
    public static function dispatcher(object $event)
    {
        return static::eventDispatcher()->dispatch($event);
    }
}