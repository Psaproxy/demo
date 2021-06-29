<?php

declare(strict_types=1);

namespace App\Infrastructure\Core\BooksCatalog\Book\MySql;

use App\Models\Book as BookModel;
use Core\BooksCatalog\Book\Book;
use Core\BooksCatalog\Book\IRepository;
use Core\BooksCatalog\Book\Props\BookId;

class Repository implements IRepository
{
    private RepoConverter $converter;

    public function __construct(RepoConverter $converter)
    {
        $this->converter = $converter;
    }

    /**
     * @throws \Throwable
     */
    public function add(Book $book): void
    {
        $model = $this->converter->toModel($book);
        $model->saveOrFail();
    }

    public function delete(BookId $id): void
    {
        BookModel::destroy($id->value());
    }

    /**
     * @throws \Throwable
     */
    public function get(BookId $id): Book
    {
        $model = BookModel::findOrFail($id->value());
        return $this->converter->toEntity($model);
    }
}
