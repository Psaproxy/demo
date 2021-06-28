<?php

declare(strict_types=1);

namespace Core\BooksCatalog\Book\Events;

use Core\BooksCatalog\Book\Props\BookId;
use Core\BooksCatalog\Book\Props\Title;
use Core\Common\Event\Event;

class BookTitleWasUpdate extends Event
{
    private BookId $id;
    private Title $title;

    public function __construct(BookId $id, Title $title)
    {
        parent::__construct();

        $this->id = $id;
        $this->title = $title;
    }

    public function id(): BookId
    {
        return $this->id;
    }

    public function title(): Title
    {
        return $this->title;
    }
}
