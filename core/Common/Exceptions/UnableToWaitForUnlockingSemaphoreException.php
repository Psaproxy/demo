<?php

declare(strict_types=1);

namespace Core\Common\Exceptions;

use Throwable;

class UnableToWaitForUnlockingSemaphoreException extends \RuntimeException
{
    public function __construct(string $name, $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            sprintf('Не удалось дождаться разблокировки семафора "%s"', $name),
            $code,
            $previous
        );
    }
}
