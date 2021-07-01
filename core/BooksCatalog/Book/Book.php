<?php

declare(strict_types=1);

namespace Core\BooksCatalog\Book;

use Core\BooksCatalog\Author\Props\AuthorId;
use Core\BooksCatalog\Book\Events\BookAuthorIdWasUpdate;
use Core\BooksCatalog\Book\Events\BookTitleWasUpdate;
use Core\BooksCatalog\Book\Events\BookWasCreated;
use Core\BooksCatalog\Book\Props\BookId;
use Core\BooksCatalog\Book\Props\Title;
use Core\Common\Event\Events;

final class Book
{
    use Events;

    private BookId $id;
    private AuthorId $authorId;
    private Title $title;
    private \DateTimeImmutable $updatedAt;
    private \DateTimeImmutable $createdAt;

    public function __construct(AuthorId $authorId, Title $title)
    {
        $this->id = new BookId();
        $this->authorId = $authorId;
        $this->title = $title;
        $this->updatedAt = new \DateTimeImmutable();
        $this->createdAt = new \DateTimeImmutable();

        $this->addEvent(new BookWasCreated($this->id, $authorId, $title));
    }

    public function id(): BookId
    {
        return $this->id;
    }

    public function authorId(): AuthorId
    {
        return $this->authorId;
    }

    public function updateAuthorId(AuthorId $authorId): self
    {
        $this->authorId = $authorId;

        $this->addEvent(new BookAuthorIdWasUpdate($this->id, $this->authorId));

        return $this;
    }

    public function title(): Title
    {
        return $this->title;
    }

    public function updateTitle(Title $title): self
    {
        $this->title = $title;

        $this->addEvent(new BookTitleWasUpdate($this->id, $this->title));

        return $this;
    }

    public function updatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
