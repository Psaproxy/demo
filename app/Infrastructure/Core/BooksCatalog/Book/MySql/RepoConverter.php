<?php

declare(strict_types=1);

namespace App\Infrastructure\Core\BooksCatalog\Book\MySql;

use App\Infrastructure\ReflectionClass;
use App\Models\Book as BookModel;
use Core\BooksCatalog\Author\Props\AuthorId;
use Core\BooksCatalog\Book\Book;
use Core\BooksCatalog\Book\Props\BookId;
use Core\BooksCatalog\Book\Props\Title;

class RepoConverter
{
    public function toModel(Book $entity): BookModel
    {
        $model = new BookModel();
        $model->id = $entity->id()->value();
        $model->author_id = $entity->authorId()->value();
        $model->title = $entity->title()->value();
        $model->created_at = $entity->createdAt();

        return $model;
    }

    /**
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function toEntity(BookModel $model): Book
    {
        /** @var Book $entity */
        /** @noinspection PhpUnnecessaryLocalVariableInspection */
        /** @noinspection PhpUndefinedMethodInspection */
        $entity = ReflectionClass::newInstanceWithoutConstructor(
            Book::class,
            [
                'id' => new BookId($model->id),
                'author_id' => new AuthorId($model->author_id),
                'title' => new Title($model->title),
                'created_at' => $model->created_at->toDateTimeImmutable(),
                'updated_at' => $model->updated_at->toDateTimeImmutable(),
            ]
        );

        return $entity;
    }

    /**
     * @param BookModel ...$models
     * @return Book[]
     * @throws \ReflectionException
     */
    public function toEntities(BookModel ...$models): array
    {
        return array_map(
            fn(BookModel $model) => $this->toEntity($model),
            $models
        );
    }
}
