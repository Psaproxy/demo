<?php

declare(strict_types=1);

namespace Core\Common\Action;

trait CacheTransactionalAction
{
    private ICacheTransaction $cacheTransaction;

    protected function initCacheTransaction(ICacheTransaction $transaction)
    {
        $this->cacheTransaction = $transaction;
    }

    /**
     * @throws \Throwable
     */
    protected function cacheTransaction(callable $processAction): void
    {
        try {
            $this->cacheTransaction->beginTransaction();
            $processAction();
            $this->cacheTransaction->commit();
        } catch (\Throwable $exception) {
            $this->cacheTransaction->rollBack();

            throw $exception;
        }
    }
}
