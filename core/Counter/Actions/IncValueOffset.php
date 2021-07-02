<?php

declare(strict_types=1);

namespace Core\Counter\Actions;

use Core\Common\Action\ISemaphores;
use Core\Common\Event\IEventsPublisher;
use Core\Counter\CounterService;
use Core\Counter\Props\CounterId;

class IncValueOffset
{
    private ISemaphores $semaphores;
    private CounterService $service;
    private IEventsPublisher $events;

    public function __construct(
        ISemaphores $semaphores,
        CounterService $service,
        IEventsPublisher $events,
    )
    {
        $this->semaphores = $semaphores;
        $this->service = $service;
        $this->events = $events;
    }

    /**
     * @throws \Throwable
     */
    public function execute(string $id): void
    {
        $this->semaphores->waitUnlocking('banner');

        $this->service->incValueOffset(new CounterId($id));
        $this->events->publish(...$this->service->releaseEvents());
    }
}