<?php

declare(strict_types=1);

namespace Core\BooksCatalog\Author\Events;

use Core\BooksCatalog\Author\Props\AuthorId;
use Core\BooksCatalog\Author\Props\Name;
use Core\Common\Event\Event;

class AuthorNameWasUpdated extends Event
{
    private AuthorId $id;
    private Name $name;

    public function __construct(AuthorId $id, Name $name)
    {
        parent::__construct();

        $this->id = $id;
        $this->name = $name;
    }

    public function id(): AuthorId
    {
        return $this->id;
    }

    public function name(): Name
    {
        return $this->name;
    }
}
