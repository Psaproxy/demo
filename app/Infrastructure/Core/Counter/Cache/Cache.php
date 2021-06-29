<?php

declare(strict_types=1);

namespace App\Infrastructure\Core\Counter\Cache;

use App\Infrastructure\Core\Counter\MySql\DBGateway;
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

    public function incValue(CounterId $id): void
    {
        $this->client->incr("counter:{$id->value()}:value");
        $this->client->set("counter:{$id->value()}:updated_at", (new \DateTimeImmutable())->getTimestamp());
    }

    public function getValue(CounterId $id): Value
    {
        $value = $this->client->get("counter:{$id->value()}:value");

        if (false !== $value) {
            return new Value((int)$value);
        }

        $value = $this->dbGateway->getValue($id);
        $this->client->set("counter:{$id->value()}:value", $value->value());

        return $value;
    }

    public function getUpdatedAt(CounterId $id): \DateTimeImmutable
    {
        $updateAt = $this->client->get("counter:{$id->value()}:updated_at");

        if (false !== $updateAt) {
            return (new \DateTimeImmutable())->setTimestamp((int)$updateAt);
        }

        $updateAt = $this->dbGateway->getUpdatedAt($id);
        $this->client->set("counter:{$id->value()}:updated_at", $updateAt->getTimestamp());

        return $updateAt;
    }

    public function heating(CounterId $id): void
    {
        $value = $this->client->get("counter:{$id->value()}:value");
        if (false === $value) {
            $value = $this->dbGateway->findValue($id);
            if (null !== $value) {
                $this->client->set("counter:{$id->value()}:value", $value->value());
            }
        }

        $updateAt = $this->client->get("counter:{$id->value()}:updated_at");
        if (false === $updateAt) {
            $updateAt = $this->dbGateway->findUpdatedAt($id);
            if (null !== $updateAt) {
                $this->client->set("counter:{$id->value()}:updated_at", $updateAt->getTimestamp());
            }
        }
    }

    public function reset(CounterId $id): void
    {
        $this->client->del(
            "counter:{$id->value()}:value",
            "counter:{$id->value()}:updated_at"
        );
    }
}
