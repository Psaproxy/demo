<?php

declare(strict_types=1);

namespace Core\BooksCatalog\Book\View;

/**
 * DTO не обязательно быть иммутабельным.
 * DTO применяется для типизации значений на замену массива.
 */
class BookDTO
{
    public string $id;
    public string $authorId;
    public string $authorName;
    public string $title;

    public function __construct(string $id, string $authorId, string $authorName, string $title)
    {
        $this->id = $id;
        $this->authorId = $authorId;
        $this->authorName = $authorName;
        $this->title = $title;
    }
}
