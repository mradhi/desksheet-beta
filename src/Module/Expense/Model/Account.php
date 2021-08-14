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

use Desksheet\Module\Expense\Factory\AccountFactory;
use Desksheet\Module\Expense\Repository\AccountRepository;
use Desksheet\Module\User\Model\UserAwareTrait;
use Desksheet\System\Attribute\Resource;
use Desksheet\System\Model\TimestampableTrait;

#[Resource(AccountRepository::class, AccountFactory::class)]
class Account implements AccountInterface
{
    use UserAwareTrait, TimestampableTrait;

    protected ?int $id = null;

    protected ?string $name = null;

    protected ?string $currency = null;

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        return strval($this->name);
    }

    /**
     * @inheritDoc
     */
    public function getId(): int|string|null
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }
}
