<?php

declare(strict_types=1);

namespace Core\BooksCatalog\Book\Actions;

use Core\BooksCatalog\Author\Props\AuthorId;
use Core\BooksCatalog\Book\Book;
use Core\BooksCatalog\Book\IRepository;
use Core\BooksCatalog\Book\Props\Title;
use Core\Common\Action\IDBTransaction;
use Core\Common\Action\DBTransactionalAction;
use Core\Common\Event\IEventsPublisher;

class Add
{
    use DBTransactionalAction;

    private IRepository $repository;
    private IEventsPublisher $events;

    public function __construct(
        IDBTransaction $dbTransaction,
        IRepository $repository,
        IEventsPublisher $events,
    )
    {
        $this->initDBTransaction($dbTransaction);
        $this->repository = $repository;
        $this->events = $events;
    }

    /**
     * Инвариант уникальности автор+название книги выполняется через хранилище.
     * Это не универсальный вариант в ввиду того, что хранилище может быть изменено.
     * Но такой вариант наиболее быстрый с минимальной нагрузкой.
     * Для универсальности можно по событию проверять уникальность.
     *
     * @throws \Throwable
     */
    public function execute(string $authorId, string $title): void
    {
        $this->dbTransaction(function () use ($authorId, $title) {
            $book = new Book(new AuthorId($authorId), new Title($title));
            $this->repository->add($book);
            $this->events->publish(...$book->releaseEvents());
        });
    }
}
