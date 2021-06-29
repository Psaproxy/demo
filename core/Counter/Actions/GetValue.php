<?php

declare(strict_types=1);

namespace Core\Counter\Actions;

use Core\Counter\ICache;
use Core\Counter\Props\CounterId;

class GetValue
{
    private ICache $cache;

    public function __construct(ICache $cache)
    {
        $this->cache = $cache;
    }

    public function execute(string $id): int
    {
        return $this->cache->getValue(new CounterId($id))->value();
    }
}
