<?php

declare(strict_types=1);

namespace Core\Counter\Actions;

use Core\Counter\ICache;
use Core\Counter\Props\CounterId;

class ResetCache
{
    private ICache $cache;

    public function __construct(ICache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @throws \Throwable
     */
    public function execute(string $id): void
    {
        $this->cache->reset(new CounterId($id));
    }
}
