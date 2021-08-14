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

trait AccountAwareTrait
{
    protected ?AccountInterface $account = null;

    public function getAccount(): ?AccountInterface
    {
        return $this->account;
    }

    public function setAccount(AccountInterface $account): void
    {
        $this->account = $account;
    }
}
