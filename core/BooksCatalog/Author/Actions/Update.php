<?php

declare(strict_types=1);

namespace Core\BooksCatalog\Author\Actions;

use Core\BooksCatalog\Author\IDBGateway;
use Core\BooksCatalog\Author\IRepository;
use Core\BooksCatalog\Author\Props\AuthorId;
use Core\BooksCatalog\Author\Props\Name;
use Core\Common\Action\IDBTransaction;
use Core\Common\Event\IEventsPublisher;

class Update
{
    private IDBTransaction $dbTransaction;
    private IRepository $repository;
    private IDBGateway $dbGateway;
    private IEventsPublisher $events;

    public function __construct(
        IDBTransaction $dbTransaction,
        IRepository $repository,
        IDBGateway $dbGateway,
        IEventsPublisher $events,
    )
    {
        $this->dbTransaction = $dbTransaction;
        $this->repository = $repository;
        $this->events = $events;
        $this->dbGateway = $dbGateway;
    }

    /**
     * Инвариант уникальности имени автора выполняется через хранилище.
     * Это не универсальный вариант в ввиду того, что хранилище может быть изменено.
     * Но такой вариант наиболее быстрый с минимальной нагрузкой.
     * Для универсальности можно по событию проверять уникальность.
     *
     * @throws \Throwable
     */
    public function execute(string $id, string $name): void
    {
        $this->dbTransaction->transaction(function () use ($id, $name) {
            $author = $this->repository->get(new AuthorId($id));
            $author->updateName(new Name($name));
            $this->dbGateway->update($author);
            $this->events->publish(...$author->releaseEvents());
        });
    }
}
