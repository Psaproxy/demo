<?php

declare(strict_types=1);

namespace Core\Common\Action;

abstract class TransactionalAction
{
    private IDBTransaction $transaction;

    public function __construct(IDBTransaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * @throws \Throwable
     */
    protected function transaction(callable $processAction): void
    {
        try {
            $this->transaction->beginTransaction();
            $processAction();
            $this->transaction->commit();
        } catch (\Throwable $exception) {
            $this->transaction->rollBack();

            throw $exception;
        }
    }
}
