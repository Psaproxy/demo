<?php

declare(strict_types=1);

namespace Core\BooksCatalog\Author;

use Core\BooksCatalog\Author\Props\AuthorId;

interface IRepository
{
    public function add(Author $author): void;

    public function delete(AuthorId $id): void;

    public function get(AuthorId $id): Author;
}
