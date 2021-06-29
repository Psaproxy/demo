<?php

declare(strict_types=1);

namespace Core\Counter\Events;

use Core\Common\Event\Event;
use Core\Counter\Props\CounterId;

class CounterUpdatedAtWasUpdated extends Event
{
    private CounterId $id;
    private \DateTimeImmutable $updateAt;

    public function __construct(CounterId $id, \DateTimeImmutable $updateAt)
    {
        parent::__construct();

        $this->id = $id;
        $this->updateAt = $updateAt;
    }

    public function id(): CounterId
    {
        return $this->id;
    }

    public function updateAt(): \DateTimeImmutable
    {
        return $this->updateAt;
    }
}
