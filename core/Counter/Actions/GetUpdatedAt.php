<?php

declare(strict_types=1);

namespace Core\Counter\Actions;

use Core\Counter\ICache;
use Core\Counter\Props\CounterId;

class GetUpdatedAt
{
    private ICache $cache;

    public function __construct(ICache $cache)
    {
        $this->cache = $cache;
    }

    public function execute(string $id): \DateTimeImmutable
    {
        return $this->cache->getUpdatedAt(new CounterId($id));
    }
}
