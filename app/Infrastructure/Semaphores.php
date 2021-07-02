<?php

declare(strict_types=1);

namespace App\Infrastructure;

use Core\Common\Action\ISemaphores;
use Core\Common\Exceptions\RuntimeException;
use Core\Common\Exceptions\UnableToWaitForLockingSemaphoreException;
use Core\Common\Exceptions\UnableToWaitForUnlockingSemaphoreException;
use Core\Common\Exceptions\UnableUnlockSemaphoreException;
use Core\Common\Exceptions\UnknownSemaphoreException;

/**
 * Блокировка семафоров с авто-разблокировкой при завершении скрипта или фатальной ошибки.
 */
class Semaphores implements ISemaphores
{
    private string $directory;

    /**
     * @var array<string, resource>
     */
    private array $handlers = [];

    public function __construct()
    {
        $this->directory = storage_path() . '/app/tmp/semaphores';
    }

    public function lock(string $name): bool
    {
        $handler = $this->openHandler($name);

        return flock($handler, LOCK_EX | LOCK_NB);
    }

    /**
     * @param string $name
     * @param int $maximumAttempts 0 - бесконечное ожидание
     * @param int $sleepMSec
     * @return bool
     * @throw UnableToWaitForLockingSemaphoreException
     */
    public function lockAndWait(string $name, int $maximumAttempts = 10, int $sleepMSec = 100): bool
    {
        $attempt = 0;
        while (false === $this->lock($name)) {
            $attempt++;

            if ($maximumAttempts > 0 && $maximumAttempts <= $attempt) {
                throw new UnableToWaitForLockingSemaphoreException($name);
            }

            usleep($sleepMSec);
        }

        return true;
    }

    public function lockAndInfinityWait(string $name, int $sleepMSec = 100): bool
    {
        return $this->lockAndWait($name, 0, $sleepMSec);
    }

    public function isLocked(string $name): bool
    {
        if (true === isset($this->handlers[$name])) {
            return true;
        }

        $filePath = $this->filePath($name);

        if (false === file_exists($filePath)) {
            return false;
        }

        $handler = $this->openHandler($name);

        return false === flock($handler, LOCK_SH | LOCK_NB);
    }

    /**
     * @param string $name
     * @param int $maximumAttempts 0 - бесконечное ожидание
     * @param int $sleepMSec
     * @return bool
     * @throw UnableToWaitForUnlockingSemaphoreException
     */
    public function waitUnlocking(string $name, int $maximumAttempts = 10, int $sleepMSec = 100): bool
    {
        $attempt = 0;
        while (true === $this->isLocked($name)) {
            $attempt++;

            if ($maximumAttempts > 0 && $maximumAttempts <= $attempt) {
                throw new UnableToWaitForUnlockingSemaphoreException($name);
            }

            usleep($sleepMSec);
        }

        return true;
    }

    public function waitInfinityUnlocking(string $name, int $sleepMSec = 100): bool
    {
        return $this->waitUnlocking($name, 0, $sleepMSec);
    }

    /**
     * @param string $name
     * @throw UnableUnlockSemaphoreException
     * @throw UnknownSemaphoreException
     */
    public function unlock(string $name): void
    {
        $handler = $this->openHandler($name);

        $state = flock($handler, LOCK_UN);

        if (false === $state) {
            throw new UnableUnlockSemaphoreException($name);
        }

        $this->closeHandler($name);
    }

    /**
     * @param string $name
     * @return resource
     */
    private function openHandler(string $name)
    {
        $filePath = $this->filePath($name);

        if (true === isset($this->handlers[$name])) {
            return $this->handlers[$name];
        }

        if (!file_exists($this->directory)) {
            mkdir($this->directory, 0777, true);
        }

        $fileHandler = fopen($filePath, 'w');

        if (false === $fileHandler) {
            throw new RuntimeException(
                sprintf('Не удалось открыть поток к файлу "%s".', $filePath)
            );
        }

        return $this->handlers[$name] = $fileHandler;
    }

    private function closeHandler(string $name): void
    {
        if (false === isset($this->handlers[$name])) {
            throw new UnknownSemaphoreException($name);
        }

        $fileHandler = $this->handlers[$name];

        $state = fclose($fileHandler);

        $filePath = $this->filePath($name);

        if (false === $state) {
            throw new RuntimeException(
                sprintf('Не удалось закрыть поток к файлу "%s".', $filePath)
            );
        }

        unset($this->handlers[$name]);

        unlink($filePath);
    }

    private function filePath(string $name): string
    {
        return sprintf('%s/%s.sem', $this->directory, hash('md5', $name));
    }
}
