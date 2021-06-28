<?php

declare(strict_types=1);

namespace Core\BooksCatalog\Book;

use Core\BooksCatalog\Book\Props\BookId;

interface IRepository
{
    public function add(Book $book): void;

    public function delete(BookId $id): void;

    public function get(BookId $id): Book;
}
