<?php

declare(strict_types=1);

namespace Core\BooksCatalog\Author;

interface IDBGateway
{
    public function update(Author $author): void;
}
