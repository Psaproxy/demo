<?php

declare(strict_types=1);

namespace Core\BooksCatalog\Book;

interface IDBGateway
{
    public function update(Book $book): void;
}
