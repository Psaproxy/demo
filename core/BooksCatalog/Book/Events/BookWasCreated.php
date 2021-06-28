<?php

declare(strict_types=1);

namespace Core\BooksCatalog\Book\Events;

use Core\BooksCatalog\Author\Props\AuthorId;
use Core\BooksCatalog\Book\Props\BookId;
use Core\BooksCatalog\Book\Props\Title;
use Core\Common\Event\Event;

class BookWasCreated extends Event
{
    private BookId $id;
    private AuthorId $authorId;
    private Title $title;

    public function __construct(BookId $id, AuthorId $authorId, Title $title)
    {
        parent::__construct();

        $this->id = $id;
        $this->authorId = $authorId;
        $this->title = $title;
    }

    public function id(): BookId
    {
        return $this->id;
    }

    public function authorId(): AuthorId
    {
        return $this->authorId;
    }

    public function title(): Title
    {
        return $this->title;
    }
}
