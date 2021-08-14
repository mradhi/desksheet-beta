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
use Desksheet\Module\User\Model\UserAwareInterface;
use Desksheet\System\Model\ResourceInterface;
use Desksheet\System\Model\TimestampableInterface;
use Stringable;

interface TransactionInterface extends ResourceInterface, UserAwareInterface, AccountAwareInterface, TimestampableInterface, Stringable
{
    public function getType(): ?int;

    public function setType(int $type): void;

    public function getAmount(): ?float;

    public function getEffectiveDate(): ?DateTimeInterface;

    public function getDescription(): ?string;
}
