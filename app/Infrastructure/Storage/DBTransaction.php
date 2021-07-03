<?php

declare(strict_types=1);

namespace App\Infrastructure\Storage;

use Core\Common\Action\IDBTransaction;
use Illuminate\Support\Facades\DB;

class DBTransaction implements IDBTransaction
{
    public function beginTransaction(): void
    {
        DB::beginTransaction();
    }

    public function rollBack(): void
    {
        DB::rollBack();
    }

    public function commit(): void
    {
        DB::commit();
    }

    /**
     * @throws \Throwable
     */
    public function transaction(callable $processAction): void
    {
        try {
            $this->beginTransaction();
            $processAction();
            $this->commit();
        } catch (\Throwable $exception) {
            $this->rollBack();

            throw $exception;
        }
    }
}
