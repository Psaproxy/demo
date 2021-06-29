<?php

declare(strict_types=1);

namespace Core\Counter;

use Core\Counter\Props\CounterId;

interface IRepository
{
    public function add(Counter $counter): void;

    public function find(CounterId $id): ?Counter;

    public function get(CounterId $id): Counter;

    public function update(Counter $counter): void;
}
