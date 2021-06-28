<?php

declare(strict_types=1);

namespace Core\BooksCatalog\Author\Actions;

use Core\BooksCatalog\Author\Author;
use Core\BooksCatalog\Author\IRepository;
use Core\BooksCatalog\Author\Props\Name;
use Core\Common\Action\IDBTransaction;
use Core\Common\Action\TransactionalAction;
use Core\Common\Event\IEventsPublisher;

class Add extends TransactionalAction
{
    private IRepository $repository;
    private IEventsPublisher $events;

    public function __construct(
        IDBTransaction $transaction,
        IRepository $repository,
        IEventsPublisher $events,
    )
    {
        parent::__construct($transaction);
        $this->repository = $repository;
        $this->events = $events;
    }

    /**
     * Инвариант уникальности имени автора выполняется через хранилище.
     * Это не универсальный вариант в ввиду того, что хранилище может быть изменено.
     * Но такой вариант наиболее быстрый с минимальной нагрузкой.
     * Для универсальности можно по событию проверять уникальность.
     *
     * @throws \Throwable
     */
    public function execute(string $name): void
    {
        $this->transaction(function () use ($name) {
            $author = new Author(new Name($name));
            $this->repository->add($author);
            $this->events->publish(...$author->releaseEvents());
        });
    }
}
