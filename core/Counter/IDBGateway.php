<?php

declare(strict_types=1);

namespace Core\Counter;

use Core\Counter\Props\CounterId;
use Core\Counter\Props\Value;

interface IDBGateway
{
    public function incValue(CounterId $id): void;

    public function findValue(CounterId $id): ?Value;

    public function getValue(CounterId $id): Value;

    public function findUpdatedAt(CounterId $id): ?\DateTimeImmutable;

    public function getUpdatedAt(CounterId $id): \DateTimeImmutable;
}
