<?php
/*
 * This file is part of the Desksheet project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desksheet\Module\Expense\Service;

use Desksheet\Module\Expense\Factory\AccountFactory;
use Desksheet\Module\Expense\Model\AccountInterface;
use Desksheet\Module\Expense\Repository\AccountRepository;
use Desksheet\Module\User\Model\UserInterface;
use Desksheet\System\Aware\ResourceManagerAware;

class AccountService
{
    use ResourceManagerAware;

    public function __construct(
        private AccountFactory $accountFactory,
        private AccountRepository $accountRepository
    )
    {
    }

    public function findByUser(UserInterface $user): array
    {
        return $this->accountRepository->findByUser($user);
    }

    public function newAccount(UserInterface $user): AccountInterface
    {
        return $this->accountFactory->createForUser($user);
    }

    public function update(AccountInterface $account): void
    {
        // Update transaction currencies when the account currency is changed.
        $this->resourceManager->importAndFlush($account);
    }

    public function remove(AccountInterface $account): void
    {
        $this->resourceManager->deleteAndFlush($account);
    }
}
