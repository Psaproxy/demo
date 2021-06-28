<?php

declare(strict_types=1);

namespace Core\BooksCatalog\Book\Events;

use Core\BooksCatalog\Author\Props\AuthorId;
use Core\BooksCatalog\Book\Props\BookId;
use Core\Common\Event\Event;

class BookAuthorIdWasUpdate extends Event
{
    private BookId $id;
    private AuthorId $authorId;

    public function __construct(BookId $id, AuthorId $authorId)
    {
        parent::__construct();

        $this->id = $id;
        $this->authorId = $authorId;
    }

    public function id(): BookId
    {
        return $this->id;
    }

    public function authorId(): AuthorId
    {
        return $this->authorId;
    }
}
