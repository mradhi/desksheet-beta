<?php
/*
 * This file is part of the Desksheet project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desksheet\Module\Expense\Factory;

use Desksheet\Module\Expense\Model\AccountInterface;
use Desksheet\Module\User\Model\UserInterface;
use Desksheet\System\Factory\ResourceFactoryInterface;
use Desksheet\System\Model\ResourceInterface;

class AccountFactory implements ResourceFactoryInterface
{
    public function __construct(private ResourceFactoryInterface $innerFactory)
    {
    }

    public function createForUser(UserInterface $user): AccountInterface
    {
        $account = $this->createNew();
        $account->setUser($user);

        return $account;
    }

    /**
     * @inheritDoc
     */
    public function createNew(): AccountInterface|ResourceInterface
    {
        return $this->innerFactory->createNew();
    }
}
