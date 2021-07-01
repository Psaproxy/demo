<?php

declare(strict_types=1);

namespace App\Infrastructure\Storage\Counter;

use App\Models\Counter as CounterModel;
use Core\Counter\Counter;
use Core\Counter\IRepository;
use Core\Counter\Props\CounterId;

class Repository implements IRepository
{
    private RepoConverter $converter;

    public function __construct(RepoConverter $converter)
    {
        $this->converter = $converter;
    }

    /**
     * @throws \Throwable
     */
    public function add(Counter $counter): void
    {
        $model = $this->converter->toModel($counter);
        $model->saveOrFail();
    }

    /**
     * @throws \ReflectionException
     */
    public function find(CounterId $id): ?Counter
    {
        $model = CounterModel::find($id->value());

        if (null === $model) {
            return null;
        }

        return $this->converter->toEntity($model);
    }

    /**
     * @throws \ReflectionException
     */
    public function get(CounterId $id): Counter
    {
        $model = CounterModel::findOrFail($id->value());
        return $this->converter->toEntity($model);
    }

    public function update(Counter $counter): void
    {
        $model = $this->converter->toModel($counter);
        $fields = $model->toArray();
        unset($fields['id']);
        $fields['created_at'] = $counter->createdAt();
        $fields['updated_at'] = $counter->updatedAt();
        CounterModel::where('id', '=', $counter->id()->value())->update($fields);
    }
}
