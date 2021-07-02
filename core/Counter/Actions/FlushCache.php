<?php

declare(strict_types=1);

namespace Core\Counter\Actions;

use Core\Common\Action\IDBTransaction;
use Core\Common\Action\ISemaphores;
use Core\Common\Action\TransactionalAction;
use Core\Common\Event\IEventsPublisher;
use Core\Counter\CounterService;
use Core\Counter\Props\CounterId;

class FlushCache extends TransactionalAction
{
    private CounterService $service;
    private IEventsPublisher $events;
    private ISemaphores $semaphores;

    public function __construct(
        IDBTransaction $transaction,
        ISemaphores $semaphores,
        CounterService $service,
        IEventsPublisher $events,
    )
    {
        parent::__construct($transaction);
        $this->service = $service;
        $this->events = $events;
        $this->semaphores = $semaphores;
    }

    /**
     * @throws \Throwable
     */
    public function execute(string $id): void
    {
        $this->semaphores->lockAndWait('banner', 50);

        $this->transaction(function () use ($id) {
            $id = new CounterId($id);
            $this->service->flushCache($id);
            $this->events->publish(...$this->service->releaseEvents());
        });
    }
}
