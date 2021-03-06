<?php

declare(strict_types=1);

namespace Core\Counter\Actions;

use Core\Common\Action\IDBTransaction;
use Core\Common\Action\ISemaphores;
use Core\Common\Event\IEventsPublisher;
use Core\Counter\CounterService;
use Core\Counter\Props\CounterId;

class FlushCache
{
    private IDBTransaction $dbTransaction;
    private CounterService $service;
    private IEventsPublisher $events;
    private ISemaphores $semaphores;

    public function __construct(
        IDBTransaction $dbTransaction,
        ISemaphores $semaphores,
        CounterService $service,
        IEventsPublisher $events,
    )
    {
        $this->dbTransaction = $dbTransaction;
        $this->service = $service;
        $this->events = $events;
        $this->semaphores = $semaphores;
    }

    /**
     * @throws \Throwable
     */
    public function execute(string $id): void
    {
        // максимум ожидания чуть больше 5 сек.
        $this->semaphores->lockAndWait('banner', 50);

        $this->dbTransaction->transaction(function () use ($id) {
            $id = new CounterId($id);
            $this->service->flushCache($id);
            $this->events->publish(...$this->service->releaseEvents());
        });
    }
}
