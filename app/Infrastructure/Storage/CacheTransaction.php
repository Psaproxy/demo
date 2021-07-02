<?php

declare(strict_types=1);

namespace App\Infrastructure\Storage;

use Core\Common\Action\ICacheTransaction;
use Illuminate\Support\Facades\Redis;

class CacheTransaction implements ICacheTransaction
{
    public function beginTransaction(): void
    {
        /** @noinspection PhpUndefinedMethodInspection */
        Redis::multi();
    }

    public function rollBack(): void
    {
        /** @noinspection PhpUndefinedMethodInspection */
        Redis::discard();
    }

    public function commit(): void
    {
        /** @noinspection PhpUndefinedMethodInspection */
        Redis::exec();
    }
}