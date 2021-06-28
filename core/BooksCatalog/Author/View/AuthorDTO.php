<?php

declare(strict_types=1);

namespace Core\BooksCatalog\Author\View;

/**
 * DTO не обязательно быть иммутабельным.
 * DTO применяется для типизации значений на замену массива.
 */
class AuthorDTO
{
    public string $id;
    public string $name;

    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
}
