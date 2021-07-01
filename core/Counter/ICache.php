<?php

declare(strict_types=1);

namespace Core\Counter;

use Core\Counter\Props\CounterId;
use Core\Counter\Props\Value;

interface ICache
{
    public function incValueOffset(CounterId $id): void;

    public function getValueOffset(CounterId $id): Value;

    public function findValue(CounterId $id): ?Value;

    public function setUpdatedAtNow(CounterId $id): void;

    public function getUpdatedAt(CounterId $id): \DateTimeImmutable;

    public function reset(CounterId $id): void;
}
