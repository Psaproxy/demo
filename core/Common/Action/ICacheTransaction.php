<?php

declare(strict_types=1);

namespace Core\Common\Action;

interface ICacheTransaction
{
    public function beginTransaction(): void;

    public function commit(): void;

    public function rollBack(): void;
}