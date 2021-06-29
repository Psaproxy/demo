<?php

declare(strict_types=1);

namespace App\Infrastructure\Core\BooksCatalog\Book\MySql;

use Core\BooksCatalog\Book\DTO\BookDTO;

class DataConverter
{
    /**
     * @param object $data
     * @return BookDTO
     */
    public function toDTO(object $data): BookDTO
    {
        return new BookDTO($data->id, $data->author_id, $data->author_name, $data->title);
    }

    /**
     * @param object ...$items
     * @return BookDTO[]
     */
    public function toDTOs(object ...$items): array
    {
        return array_map(
            fn(object $data) => $this->toDTO($data),
            $items
        );
    }
}
