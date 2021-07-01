<?php

declare(strict_types=1);

namespace Core\Counter;

use Core\Common\Event\Events;
use Core\Counter\Events\CounterUpdatedAtWasUpdated;
use Core\Counter\Events\CounterValueWasUpdated;
use Core\Counter\Events\CounterWasCreated;
use Core\Counter\Props\CounterId;
use Core\Counter\Props\Value;

final class Counter
{
    use Events;

    private CounterId $id;
    private Value $value;
    private \DateTimeImmutable $updatedAt;
    private \DateTimeImmutable $createdAt;

    public function __construct(CounterId $id, Value $value)
    {
        $this->id = $id;
        $this->value = $value;
        $this->updatedAt = new \DateTimeImmutable();
        $this->createdAt = new \DateTimeImmutable();

        $this->addEvent(new CounterWasCreated($this->id, $value));
    }

    public function id(): CounterId
    {
        return $this->id;
    }

    public function value(): Value
    {
        return $this->value;
    }

    public function setValue(Value $value): self
    {
        $this->value = $value;

        $this->addEvent(new CounterValueWasUpdated($this->id, $this->value));

        return $this;
    }

    public function incValue(Value $value = null): self
    {
        $this->value->inc(null === $value ? new Value() : $value);

        $this->addEvent(new CounterValueWasUpdated($this->id, $this->value));

        return $this;
    }

    public function updatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $dateTime): self
    {
        $this->updatedAt = $dateTime;

        $this->addEvent(new CounterUpdatedAtWasUpdated($this->id, $this->updatedAt));

        return $this;
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
