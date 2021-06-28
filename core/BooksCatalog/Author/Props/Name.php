<?php

declare(strict_types=1);

namespace Core\BooksCatalog\Author\Props;

use Core\Common\Entity\Text;
use Core\Common\Exceptions\InvalidArgumentException;

final class Name extends Text
{
    public function __construct(string $value)
    {
        $value = trim($value);

        if ('' === $value) {
            throw new InvalidArgumentException('Имени автора не может быть пустой строкой.');
        }

        if (255 < \mb_strlen($value)) {
            throw new InvalidArgumentException('Имени автора не должна быть длиннее 255 знаков.');
        }

        parent::__construct($value);
    }
}
