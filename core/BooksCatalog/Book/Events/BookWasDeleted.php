<?php

declare(strict_types=1);

namespace Core\BooksCatalog\Book\Events;

use Core\BooksCatalog\Book\Props\BookId;
use Core\Common\Event\Event;

class BookWasDeleted extends Event
{
    private BookId $id;

    public function __construct(BookId $id)
    {
        parent::__construct();

        $this->id = $id;
    }

    public function id(): BookId
    {
        return $this->id;
    }
}
