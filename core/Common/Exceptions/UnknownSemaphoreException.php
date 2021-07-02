<?php

declare(strict_types=1);

namespace Core\Common\Exceptions;

use Throwable;

class UnknownSemaphoreException extends \RuntimeException
{
    public function __construct(string $name, $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            sprintf('Неизвестный семафор "%s"', $name),
            $code,
            $previous
        );
    }
}
