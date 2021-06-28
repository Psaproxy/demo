<?php

declare(strict_types=1);

namespace Core\BooksCatalog\Book;

use Core\BooksCatalog\Book\Props\BookId;
use Core\BooksCatalog\Book\View\BookDTO;

interface IDataProvider
{
    /**
     * @return BookDTO[]
     */
    public function all(): array;

    /**
     * @return BookDTO[]
     */
    public function allWithSortingByTitle(): array;

    public function get(BookId $id): BookDTO;
}
