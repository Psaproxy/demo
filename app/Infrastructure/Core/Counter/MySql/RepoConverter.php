<?php

declare(strict_types=1);

namespace App\Infrastructure\Core\Counter\MySql;

use App\Infrastructure\ReflectionClass;
use App\Models\Counter as CounterModel;
use Core\Counter\Counter;
use Core\Counter\Props\CounterId;
use Core\Counter\Props\Value;

class RepoConverter
{
    public function toModel(Counter $entity): CounterModel
    {
        $model = new CounterModel();
        $model->id = $entity->id()->value();
        $model->value = $entity->value()->value();
        $model->created_at = $entity->createdAt();
        $model->updated_at = $entity->updatedAt();

        return $model;
    }

    /**
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function toEntity(CounterModel $model): Counter
    {
        /** @var Counter $entity */
        /** @noinspection PhpUnnecessaryLocalVariableInspection */
        /** @noinspection PhpUndefinedMethodInspection */
        /** @noinspection PhpCastIsUnnecessaryInspection */
        $entity = ReflectionClass::newInstanceWithoutConstructor(
            Counter::class,
            [
                'id' => new CounterId($model->id),
                'value' => new Value((int)$model->value),
                'created_at' => $model->created_at->toDateTimeImmutable(),
                'updated_at' => $model->updated_at->toDateTimeImmutable(),
            ]
        );

        return $entity;
    }
}
