<?php

declare(strict_types=1);

namespace Core\BooksCatalog\Author;

use Core\BooksCatalog\Author\Props\AuthorId;
use Core\BooksCatalog\Author\Props\Name;
use Core\BooksCatalog\Author\DTO\AuthorDTO;

interface IDataProvider
{
    /**
     * @return AuthorDTO[]
     */
    public function all(): array;

    /**
     * @return AuthorDTO[]
     */
    public function allWithSortingByName(): array;

    public function get(AuthorId $id): AuthorDTO;

    /**
     * @return Name[]
     */
    public function allNames(): array;
}
