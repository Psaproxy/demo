<?php

declare(strict_types=1);

namespace App\Infrastructure\Storage\Counter;

use Core\Counter\ICache;
use Core\Counter\Props\CounterId;
use Core\Counter\Props\Value;
use Illuminate\Support\Facades\Redis;

class Cache implements ICache
{
    private DBGateway $dbGateway;
    private \Redis $client;

    public function __construct(DBGateway $dbGateway)
    {
        $this->dbGateway = $dbGateway;
        $this->client = Redis::connection()->client();
    }

    public function incValueOffset(CounterId $id): void
    {
        $this->client->incr($this->key($id, 'value_offset'));
    }

    public function getValueOffset(CounterId $id): Value
    {
        $value = $this->client->get($this->key($id, 'value_offset'));

        return new Value((int)$value);
    }

    public function findValue(CounterId $id): ?Value
    {
        $value = $this->client->get($this->key($id, 'value'));

        if (false === $value) {
            $value = (string)$this->dbGateway->findValue($id);
            $this->client->set($this->key($id, 'value'), $value);
        }

        return false === $value ? null : new Value((int)$value);
    }

    public function setUpdatedAtNow(CounterId $id): void
    {
        $this->client->set($this->key($id, 'updated_at'), (new \DateTimeImmutable())->getTimestamp());
    }

    public function getUpdatedAt(CounterId $id): \DateTimeImmutable
    {
        $updateAt = $this->client->get($this->key($id, 'updated_at'));

        if (false !== $updateAt) {
            return (new \DateTimeImmutable())->setTimestamp((int)$updateAt);
        }

        $updateAt = $this->dbGateway->getUpdatedAt($id);

        $this->client->set($this->key($id, 'updated_at'), $updateAt->getTimestamp());

        return $updateAt;
    }

    public function reset(CounterId $id): void
    {
        $this->client->del(
            $this->key($id, 'value_offset'),
            $this->key($id, 'value'),
            $this->key($id, 'updated_at'),
        );
    }

    private function key(CounterId $id, string $key): string
    {
        return "counter:{$id->value()}:$key";
    }
}
