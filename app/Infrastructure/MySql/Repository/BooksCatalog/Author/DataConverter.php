<?php

declare(strict_types=1);

namespace App\Infrastructure\MySql\Repository\BooksCatalog\Author;

use App\Models\BookAuthor as AuthorModel;
use Core\BooksCatalog\Author\Author;
use Core\BooksCatalog\Author\View\AuthorDTO;
use Core\BooksCatalog\Author\View\NameDTO;

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
