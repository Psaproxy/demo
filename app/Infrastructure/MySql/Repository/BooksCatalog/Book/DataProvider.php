<?php

declare(strict_types=1);

namespace App\Infrastructure\MySql\Repository\BooksCatalog\Book;

use Core\BooksCatalog\Book\IDataProvider;
use Core\BooksCatalog\Book\Props\BookId;
use Core\BooksCatalog\Book\View\BookDTO;
use Illuminate\Support\Facades\DB;

class DataProvider implements IDataProvider
{
    private DataConverter $converter;

    public function __construct(DataConverter $converter)
    {
        $this->converter = $converter;
    }

    public function get(BookId $id): BookDTO
    {
        $data = DB::table('books')
            ->select('books.*', 'books_authors.name as author_name')
            ->leftJoin('books_authors', 'books.author_id', '=', 'books_authors.id')
            ->where('books.id', '=', $id->value())
            ->first();

        return $this->converter->toDTO($data);
    }

    /**
     * @return BookDTO[]
     */
    public function all(string $sortBy = ''): array
    {
        $query = DB::table('books')
            ->leftJoin('books_authors', 'books.author_id', '=', 'books_authors.id')
            ->select('books.*', 'books_authors.name as author_name');

        if ('' !== $sortBy) {
            $query->orderBy($sortBy);
        }

        $books = $query->get()->toArray();

        return $this->converter->toDTOs(...$books);
    }

    /**
     * @return BookDTO[]
     */
    public function allWithSortingByTitle(): array
    {
        return $this->all('title');
    }
}
