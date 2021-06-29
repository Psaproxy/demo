<?php

declare(strict_types=1);

namespace Core\Common\Event;

trait Events
{
    /**
     * @var array<Event>
     */
    private array $events = [];

    private function addEvent(Event $event): void
    {
        $this->events[] = $event;
    }

    private function pushEvents(Event ...$events): void
    {
        $this->events = array_merge($this->events, $events);
    }

    /**
     * @return array<Event>
     */
    public function releaseEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }
}
