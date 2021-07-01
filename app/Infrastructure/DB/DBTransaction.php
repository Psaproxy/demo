<?php

declare(strict_types=1);

namespace App\Infrastructure\DB;

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
}
