<?php

declare(strict_types=1);

namespace Core\Counter\Events;

use Core\Common\Event\Event;
use Core\Counter\Props\CounterId;
use Core\Counter\Props\Value;

class CounterWasCreated extends Event
{
    private CounterId $id;
    private Value $value;

    public function __construct(CounterId $id, Value $value)
    {
        parent::__construct();

        $this->id = $id;
        $this->value = $value;
    }

    public function id(): CounterId
    {
        return $this->id;
    }

    public function value(): Value
    {
        return $this->value;
    }
}
