<?php

declare(strict_types=1);

namespace App\Infrastructure\Storage\BooksCatalog\Author;

use App\Models\BookAuthor as BookAuthorModel;
use Core\BooksCatalog\Author\Author;
use Core\BooksCatalog\Author\IRepository;
use Core\BooksCatalog\Author\Props\AuthorId;

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
    public function add(Author $author): void
    {
        $model = $this->converter->toModel($author);
        $model->saveOrFail();
    }

    public function delete(AuthorId $id): void
    {
        BookAuthorModel::destroy($id->value());
    }

    /**
     * @throws \Throwable
     */
    public function get(AuthorId $id): Author
    {
        $model = BookAuthorModel::findOrFail($id->value());
        return $this->converter->toEntity($model);
    }
}
