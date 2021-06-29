<?php

declare(strict_types=1);

namespace App\Infrastructure\Core\Counter\MySql;

use Core\Common\Exceptions\EntityNotFoundException;
use Core\Counter\IDBGateway;
use Core\Counter\Props\CounterId;
use Core\Counter\Props\Value;
use Illuminate\Support\Facades\DB;

class DBGateway implements IDBGateway
{
    public function incValue(CounterId $id): void
    {
        /** @noinspection UnknownColumnInspection */
        DB::update('
            update counters 
            set value = 1 + value 
            where id = :id',
            [
                ':id' => $id->value(),
                ':updated_at' => (new \DateTimeImmutable())->getTimestamp(),
            ],
        );
    }

    public function findValue(CounterId $id): ?Value
    {
        $data = DB::selectOne('
            select value
            from counters 
            where id = :id',
            [':id' => $id->value()],
        );
        return null === $data ? null : new Value((int)$data->value);
    }

    public function getValue(CounterId $id): Value
    {
        $value = $this->findValue($id);

        if (null === $value) {
            throw new EntityNotFoundException($id->value());
        }

        return $value;
    }

    public function findUpdatedAt(CounterId $id): ?\DateTimeImmutable
    {
        $data = DB::selectOne('
            select updated_at
            from counters 
            where id = :id',
            [':id' => $id->value()],
        );

        return null === $data ? null : (new \DateTimeImmutable())->setTimestamp((int)$data->updated_at);
    }

    public function getUpdatedAt(CounterId $id): \DateTimeImmutable
    {
        $updatedAt = $this->findUpdatedAt($id);

        if (null === $updatedAt) {
            throw new EntityNotFoundException($id->value());
        }

        return $updatedAt;
    }
}
