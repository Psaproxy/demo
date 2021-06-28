<?php

declare(strict_types=1);

namespace App\Infrastructure\Event;

use Core\Common\Event\Event;
use Core\Common\Event\IEventsPublisher;

class EventsPublisher implements IEventsPublisher
{
    public function publish(Event ...$events): void
    {
        foreach ($events as $event) {
            \event($event);
        }
    }
}
