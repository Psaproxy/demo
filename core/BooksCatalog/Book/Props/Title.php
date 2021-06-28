<?php

declare(strict_types=1);

namespace Core\BooksCatalog\Book\Props;

use Core\Common\Entity\Text;
use Core\Common\Exceptions\InvalidArgumentException;

final class Title extends Text
{
    public function __construct(string $value)
    {
        $value = trim($value);

        if ('' === $value) {
            throw new InvalidArgumentException('Название книги не может быть пустой строкой.');
        }

        if (255 < \mb_strlen($value)) {
            throw new InvalidArgumentException('Название книги не должно быть длиннее 255 знаков.');
        }

        parent::__construct($value);
    }
}
