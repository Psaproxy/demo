<?php

declare(strict_types=1);

namespace Core\BooksCatalog\Author\Actions;

use Core\BooksCatalog\Author\Props\AuthorId;
use Core\BooksCatalog\BooksCatalogService;
use Core\Common\Action\IDBTransaction;
use Core\Common\Action\TransactionalAction;
use Core\Common\Event\IEventsPublisher;

class Delete extends TransactionalAction
{
    private BooksCatalogService $service;
    private IEventsPublisher $events;

    public function __construct(
        IDBTransaction $transaction,
        BooksCatalogService $service,
        IEventsPublisher $events,
    )
    {
        parent::__construct($transaction);
        $this->service = $service;
        $this->events = $events;
    }

    /**
     * Инвариант удаления книг автора выполняется через хранилище.
     * Это не универсальный вариант в ввиду того, что хранилище может быть изменено.
     * Но такой вариант наиболее быстрый с минимальной нагрузкой.
     * Для универсальности можно по событию удалять сирот.
     *
     * @throws \Throwable
     */
    public function execute(string $authorId): void
    {
        $this->transaction(function () use ($authorId) {
            $this->service->deleteAuthor(new AuthorId($authorId));
            $this->events->publish(...$this->service->releaseEvents());
        });
    }
}
