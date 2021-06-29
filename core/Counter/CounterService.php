<?php

declare(strict_types=1);

namespace Core\Counter;

use Core\Common\Event\Events;
use Core\Counter\Events\CounterCacheWasFlushed;
use Core\Counter\Props\CounterId;
use Core\Counter\Props\Value;

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

    public function incValue(CounterId $id): void
    {
        // Прогрев кеша.
        $this->cache->heating($id);

        $this->cache->incValue($id);
    }

    public function flushCache(CounterId $id): void
    {
        $isNewCounter = false;
        $counter = $this->repository->find($id);

        if (null === $counter) {
            $isNewCounter = true;
            $counter = new Counter($id, new Value(0));
        }

        $counter->setValue($this->cache->getValue($id));
        $counter->setUpdatedAt($this->cache->getUpdatedAt($id));

        if (true === $isNewCounter) {
            $this->repository->add($counter);
        } else {
            $this->repository->update($counter);
        }

        $this->pushEvents(...$counter->releaseEvents());
        $this->addEvent(new CounterCacheWasFlushed($id));
    }
}
