<?php
/*
 * This file is part of the Desksheet project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desksheet\Module\Expense\Model;

use DateTimeInterface;
use Desksheet\Module\User\Model\UserAwareTrait;
use Desksheet\System\Model\TimestampableTrait;

class Transaction implements TransactionInterface
{
    use AccountAwareTrait, UserAwareTrait, TimestampableTrait;

    protected ?int $id = null;

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        return strval($this->id);
    }

    /**
     * @inheritDoc
     */
    public function getId(): int|string|null
    {
        return $this->id;
    }

    public function getType(): ?int
    {
        // TODO: Implement getType() method.
    }

    public function setType(int $type): void
    {
        // TODO: Implement setType() method.
    }

    public function getAmount(): ?float
    {
        // TODO: Implement getAmount() method.
    }

    public function getEffectiveDate(): ?DateTimeInterface
    {
        // TODO: Implement getEffectiveDate() method.
    }

    public function getDescription(): ?string
    {
        // TODO: Implement getDescription() method.
    }
}
