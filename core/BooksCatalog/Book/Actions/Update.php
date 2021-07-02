<?php

declare(strict_types=1);

namespace Core\BooksCatalog\Book\Actions;

use Core\BooksCatalog\Author\Props\AuthorId;
use Core\BooksCatalog\Book\IDBGateway;
use Core\BooksCatalog\Book\IRepository;
use Core\BooksCatalog\Book\Props\BookId;
use Core\BooksCatalog\Book\Props\Title;
use Core\Common\Action\DBTransactionalAction;
use Core\Common\Action\IDBTransaction;
use Core\Common\Event\IEventsPublisher;

class Update
{
    use DBTransactionalAction;

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
        $this->initDBTransaction($dbTransaction);
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
    public function execute(string $id, string $authorId, string $title): void
    {
        $this->dbTransaction(function () use ($id, $authorId, $title) {
            $book = $this->repository->get(new BookId($id));
            $book->updateAuthorId(new AuthorId($authorId));
            $book->updateTitle(new Title($title));
            $this->dbGateway->update($book);
            $this->events->publish(...$book->releaseEvents());
        });
    }
}
