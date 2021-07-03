<?php

declare(strict_types=1);

namespace Core\Common\Action;

interface IDBTransaction
{
    public function beginTransaction(): void;

    public function commit(): void;

    public function rollBack(): void;

    /**
     * @throws \Throwable
     */
    public function transaction(callable $processAction): void;
}