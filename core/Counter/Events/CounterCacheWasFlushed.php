<?php

declare(strict_types=1);

namespace Core\Counter\Events;

use Core\Common\Event\Event;
use Core\Counter\Props\CounterId;

class CounterCacheWasFlushed extends Event
{
    private CounterId $id;

    public function __construct(CounterId $id)
    {
        parent::__construct();

        $this->id = $id;
    }

    public function id(): CounterId
    {
        return $this->id;
    }
}
