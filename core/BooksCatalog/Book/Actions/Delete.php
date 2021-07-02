<?php

declare(strict_types=1);

namespace Core\BooksCatalog\Book\Actions;

use Core\BooksCatalog\Book\Props\BookId;
use Core\BooksCatalog\BooksCatalogService;
use Core\Common\Action\IDBTransaction;
use Core\Common\Action\DBTransactionalAction;
use Core\Common\Event\IEventsPublisher;

class Delete
{
    use DBTransactionalAction;

    private BooksCatalogService $service;
    private IEventsPublisher $events;

    public function __construct(
        IDBTransaction $dbTransaction,
        BooksCatalogService $service,
        IEventsPublisher $events,
    )
    {
        $this->initDBTransaction($dbTransaction);
        $this->service = $service;
        $this->events = $events;
    }

    /**
     * @throws \Throwable
     */
    public function execute(string $id): void
    {
        $this->dbTransaction(function () use ($id) {
            $this->service->deleteBook(new BookId($id));
            $this->events->publish(...$this->service->releaseEvents());
        });
    }
}
