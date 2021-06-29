<?php

declare(strict_types=1);

namespace Core\Counter\Actions;

use Core\Common\Event\IEventsPublisher;
use Core\Counter\CounterService;
use Core\Counter\Props\CounterId;

class IncValue
{
    private CounterService $service;
    private IEventsPublisher $events;

    public function __construct(CounterService $service, IEventsPublisher $events)
    {
        $this->service = $service;
        $this->events = $events;
    }

    /**
     * @throws \Throwable
     */
    public function execute(string $id): void
    {
        $this->service->incValue(new CounterId($id));
        $this->events->publish(...$this->service->releaseEvents());
    }
}
