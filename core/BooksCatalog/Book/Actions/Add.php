<?php

declare(strict_types=1);

namespace Core\BooksCatalog\Book\Actions;

use Core\BooksCatalog\Author\Props\AuthorId;
use Core\BooksCatalog\Book\Book;
use Core\BooksCatalog\Book\IRepository;
use Core\BooksCatalog\Book\Props\Title;
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
     * Инвариант уникальности автор+название книги выполняется через хранилище.
     * Это не универсальный вариант в ввиду того, что хранилище может быть изменено.
     * Но такой вариант наиболее быстрый с минимальной нагрузкой.
     * Для универсальности можно по событию проверять уникальность.
     *
     * @throws \Throwable
     */
    public function execute(string $authorId, string $title): void
    {
        $this->transaction(function () use ($authorId, $title) {
            $book = new Book(new AuthorId($authorId), new Title($title));
            $this->repository->add($book);
            $this->events->publish(...$book->releaseEvents());
        });
    }
}
