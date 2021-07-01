<?php

declare(strict_types=1);

namespace Core\Counter\DTO;

class StatDTO
{
    public int $value;
    public ?\DateTimeImmutable $updateAt;

    public function __construct(int $value, ?\DateTimeImmutable $updateAt)
    {
        $this->value = $value;
        $this->updateAt = $updateAt;
    }
}
