<?php

declare(strict_types=1);

namespace Core\Common\Entity;

class Number
{
    protected int $value;

    public function __construct(int $value = 0)
    {
        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string)$this->value();
    }

    public function equals(Number $value): bool
    {
        return $this->value() === $value->value();
    }

    public function isEmpty(): bool
    {
        return empty($this->value());
    }
}
