<?php

declare(strict_types=1);

namespace App\Infrastructure\Core\BooksCatalog\Author\MySql;

use App\Models\BookAuthor as BookAuthorModel;
use Core\BooksCatalog\Author\Author;
use Core\BooksCatalog\Author\IDBGateway;

class DBGateway implements IDBGateway
{
    public function update(Author $author): void
    {
        BookAuthorModel::where('id', $author->id()->value())
            ->update([
                'name' => $author->name()->value(),
            ]);
    }
}
