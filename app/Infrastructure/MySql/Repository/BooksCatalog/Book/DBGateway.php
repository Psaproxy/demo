<?php

declare(strict_types=1);

namespace App\Infrastructure\MySql\Repository\BooksCatalog\Book;

use App\Models\Book as BookModel;
use Core\BooksCatalog\Book\Book;
use Core\BooksCatalog\Book\IDBGateway;

class DBGateway implements IDBGateway
{
    public function update(Book $book): void
    {
        BookModel::where('id', $book->id()->value())
            ->update([
                'author_id' => $book->authorId()->value(),
                'title' => $book->title()->value(),
            ]);
    }
}
