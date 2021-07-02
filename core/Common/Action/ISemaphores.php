<?php

declare(strict_types=1);

namespace Core\Common\Action;

/**
 * Блокировка семафоров с авто-разблокировкой при завершении скрипта или фатальной ошибки.
 */
interface ISemaphores
{
    public function lock(string $name): bool;

    /**
     * @param string $name
     * @param int $maximumAttempts
     * @param int $sleepMSec
     * @return bool
     * @throw UnableToWaitForLockingSemaphoreException
     */
    public function lockAndWait(string $name, int $maximumAttempts = 10, int $sleepMSec = 100): bool;

    public function lockAndInfinityWait(string $name, int $sleepMSec = 100): bool;

    public function isLocked(string $name): bool;

    /**
     * @param string $name
     * @param int $maximumAttempts
     * @param int $sleepMSec
     * @return bool
     * @throw UnableToWaitForUnlockingSemaphoreException
     */
    public function waitUnlocking(string $name, int $maximumAttempts = 10, int $sleepMSec = 100): bool;

    public function waitInfinityUnlocking(string $name, int $sleepMSec = 100): bool;

    /**
     * @param string $name
     * @throw UnableUnlockSemaphoreException
     * @throw UnknownSemaphoreException
     */
    public function unlock(string $name): void;
}