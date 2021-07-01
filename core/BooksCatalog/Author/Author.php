<?php

declare(strict_types=1);

namespace Core\BooksCatalog\Author;

use Core\BooksCatalog\Author\Events\AuthorNameWasUpdated;
use Core\BooksCatalog\Author\Events\AuthorWasCreated;
use Core\BooksCatalog\Author\Props\AuthorId;
use Core\BooksCatalog\Author\Props\Name;
use Core\Common\Event\Events;

final class Author
{
    use Events;

    private AuthorId $id;
    private Name $name;
    private \DateTimeImmutable $updatedAt;
    private \DateTimeImmutable $createdAt;

    public function __construct(Name $name)
    {
        $this->id = new AuthorId();
        $this->name = $name;
        $this->updatedAt = new \DateTimeImmutable();
        $this->createdAt = new \DateTimeImmutable();

        $this->addEvent(new AuthorWasCreated($this->id, $name));
    }

    public function id(): AuthorId
    {
        return $this->id;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function updateName(Name $name): self
    {
        $this->name = $name;

        $this->addEvent(new AuthorNameWasUpdated($this->id, $this->name));

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
