<?php

declare(strict_types=1);

namespace Core\Common\Action;

trait DBTransactionalAction
{
    private IDBTransaction $dbTransaction;

    protected function initDBTransaction(IDBTransaction $transaction)
    {
        $this->dbTransaction = $transaction;
    }

    /**
     * @throws \Throwable
     */
    protected function dbTransaction(callable $processAction): void
    {
        try {
            $this->dbTransaction->beginTransaction();
            $processAction();
            $this->dbTransaction->commit();
        } catch (\Throwable $exception) {
            $this->dbTransaction->rollBack();

            throw $exception;
        }
    }
}
