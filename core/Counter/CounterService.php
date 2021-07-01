<?php

declare(strict_types=1);

namespace Core\Counter;

use Core\Common\Event\Events;
use Core\Counter\Events\CounterCacheWasFlushed;
use Core\Counter\Props\CounterId;

class CounterService
{
    use Events;

    private ICache $cache;
    private IRepository $repository;

    public function __construct(ICache $cache, IRepository $repository)
    {
        $this->cache = $cache;
        $this->repository = $repository;
    }

    public function incValueOffset(CounterId $id): void
    {
        $this->cache->incValueOffset($id);
        $this->cache->setUpdatedAtNow($id);
    }

    public function flushCache(CounterId $id): void
    {
        $valueOffset = $this->cache->getValueOffset($id);

        if (true === $valueOffset->isEmpty()) {
            return;
        }

        $counter = $this->repository->find($id);
        if (null === $counter) {
            $counter = new Counter($id, $valueOffset);
            $this->repository->add($counter);
        } else {
            $counter->incValue($valueOffset);
            $counter->setUpdatedAt($this->cache->getUpdatedAt($id));
            $this->repository->update($counter);
        }

        $this->pushEvents(...$counter->releaseEvents());
        $this->addEvent(new CounterCacheWasFlushed($id));
    }
}
