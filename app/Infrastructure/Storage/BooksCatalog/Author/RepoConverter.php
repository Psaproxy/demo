<?php

declare(strict_types=1);

namespace App\Infrastructure\Storage\BooksCatalog\Author;

use App\Infrastructure\ReflectionClass;
use App\Models\BookAuthor as AuthorModel;
use Core\BooksCatalog\Author\Author;
use Core\BooksCatalog\Author\Props\AuthorId;
use Core\BooksCatalog\Author\Props\Name;

class RepoConverter
{
    public function toModel(Author $entity): AuthorModel
    {
        $model = new AuthorModel();
        $model->id = $entity->id()->value();
        $model->name = $entity->name()->value();
        $model->created_at = $entity->createdAt();

        return $model;
    }

    /**
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function toEntity(AuthorModel $model): Author
    {
        /** @var Author $entity */
        /** @noinspection PhpUnnecessaryLocalVariableInspection */
        /** @noinspection PhpUndefinedMethodInspection */
        $entity = ReflectionClass::newInstanceWithoutConstructor(
            Author::class,
            [
                'id' => new AuthorId($model->id),
                'name' => new Name($model->name),
                'created_at' => $model->created_at->toDateTimeImmutable(),
                'updated_at' => $model->updated_at->toDateTimeImmutable(),
            ]
        );

        return $entity;
    }

    /**
     * @param AuthorModel ...$models
     * @return Author[]
     * @throws \ReflectionException
     */
    public function toEntities(AuthorModel ...$models): array
    {
        return array_map(
            fn(AuthorModel $model) => $this->toEntity($model),
            $models
        );
    }
}
