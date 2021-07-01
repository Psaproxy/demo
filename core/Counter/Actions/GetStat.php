<?php

declare(strict_types=1);

namespace Core\Counter\Actions;

use Core\Counter\DTO\StatDTO;
use Core\Counter\ICache;
use Core\Counter\Props\CounterId;

class GetStat
{
    private ICache $cache;

    public function __construct(ICache $cache)
    {
        $this->cache = $cache;
    }

    public function execute(string $id): StatDTO
    {
        $id = new CounterId($id);

        $valueOffset = $this->cache->getValueOffset($id);
        $value = $this->cache->findValue($id);
        if (null !== $value) {
            $valueOffset->inc($value);
        }

        if (false === $valueOffset->isEmpty()) {
            $updatedAt = $this->cache->getUpdatedAt($id);
        } else {
            $updatedAt = null;
        }

        return new StatDTO($valueOffset->value(), $updatedAt);
    }
}
