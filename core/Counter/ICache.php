<?php

declare(strict_types=1);

namespace Core\Counter;

use Core\Counter\Props\CounterId;
use Core\Counter\Props\Value;

interface ICache
{
    public function incValue(CounterId $id): void;

    public function getValue(CounterId $id): Value;

    public function getUpdatedAt(CounterId $id): \DateTimeImmutable;

    public function heating(CounterId $id): void;

    public function reset(CounterId $id): void;
}
