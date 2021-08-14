<?php
/*
 * This file is part of the Desksheet project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desksheet\Module\Expense\DataTransfer;

use Desksheet\Module\Expense\Request\TransactionRequest;
use Desksheet\Module\Expense\Model\Transaction;
use Desksheet\Module\Expense\Model\TransactionInterface;
use Desksheet\System\DataTransfer\ObjectDataTransferor;

/**
 * Transfer TransactionRequest object data to Transaction entity
 * and vice versa.
 */
class TransactionRequestTransferor extends ObjectDataTransferor
{
    /**
     * @inheritDoc
     */
    public static function getSupportedClasses(): array
    {
        return [TransactionRequest::class, Transaction::class];
    }

    /**
     * @inheritDoc
     *
     * @param TransactionRequest $request
     * @param TransactionInterface $transaction
     */
    public function transfer($request, &$transaction): void
    {
        dump('transform');
    }

    /**
     * @inheritDoc
     *
     * @param TransactionInterface $transaction
     * @param TransactionRequest $request
     */
    public function reverseTransfer($transaction, $request): void
    {
        dump('reverseTransform');
    }
}
