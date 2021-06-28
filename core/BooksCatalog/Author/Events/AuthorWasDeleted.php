<?php

declare(strict_types=1);

namespace Core\BooksCatalog\Author\Events;

use Core\BooksCatalog\Author\Props\AuthorId;
use Core\Common\Event\Event;

class AuthorWasDeleted extends Event
{
    private AuthorId $id;

    public function __construct(AuthorId $id)
    {
        parent::__construct();

        $this->id = $id;
    }

    public function id(): AuthorId
    {
        return $this->id;
    }
}
