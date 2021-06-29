<?php

declare(strict_types=1);

namespace App\Infrastructure\Core\BooksCatalog\Author\MySql;

use App\Models\BookAuthor as AuthorModel;
use Core\BooksCatalog\Author\Author;
use Core\BooksCatalog\Author\DTO\AuthorDTO;
use Core\BooksCatalog\Author\DTO\NameDTO;

class DataConverter
{
    public function toDTO(AuthorModel $model): AuthorDTO
    {
        return new AuthorDTO($model->id, $model->name);
    }

    /**
     * @param AuthorModel ...$models
     * @return Author[]
     */
    public function toDTOs(AuthorModel ...$models): array
    {
        return array_map(
            fn(AuthorModel $model) => $this->toDTO($model),
            $models
        );
    }

    public function nameToDTO(object $data): NameDTO
    {
        return new NameDTO($data->id, $data->name);
    }

    /**
     * @param object ...$items
     * @return NameDTO[]
     */
    public function namesToDTOs(object ...$items): array
    {
        return array_map(
            fn(object $data) => $this->nameToDTO($data),
            $items
        );
    }
}
