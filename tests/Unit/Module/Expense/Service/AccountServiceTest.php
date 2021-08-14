<?php
/*
 * This file is part of the Desksheet project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desksheet\Tests\Unit\Module\Expense\Service;

use Desksheet\Module\Expense\Factory\AccountFactory;
use Desksheet\Module\Expense\Model\Account;
use Desksheet\Module\Expense\Repository\AccountRepository;
use Desksheet\Module\Expense\Service\AccountService;
use Desksheet\Module\User\Model\User;
use Desksheet\System\Manager\ResourceManagerInterface;
use PHPUnit\Framework\TestCase;

class AccountServiceTest extends TestCase
{
    private ?AccountService $accountService;
    private ?AccountFactory $accountFactory;
    private ?AccountRepository $accountRepository;
    private ?ResourceManagerInterface $resourceManager;

    protected function setUp(): void
    {
        $this->accountService = new AccountService(
            $this->accountFactory = $this->createMock(AccountFactory::class),
            $this->accountRepository = $this->createMock(AccountRepository::class)
        );

        $this->accountService->setResourceManager(
            $this->resourceManager = $this->createMock(ResourceManagerInterface::class)
        );
    }

    protected function tearDown(): void
    {
        $this->accountService = null;
        $this->accountFactory = null;
        $this->accountRepository = null;
        $this->resourceManager = null;
    }

    public function testItFindAccountsByUser(): void
    {
        $user = new User();

        $this->accountRepository
            ->expects($this->once())
            ->method('findByUser')
            ->with($user)
            ->willReturn($result = []);

        $this->assertSame($result, $this->accountService->findByUser($user));
    }

    public function testItUpdatesAGivenAccount(): void
    {
        $this->resourceManager
            ->expects($this->once())
            ->method('importAndFlush')
            ->with($account = new Account());

        $this->accountService->update($account);
    }

    public function testItRemovesAGivenAccount(): void
    {
        $this->resourceManager
            ->expects($this->once())
            ->method('deleteAndFlush')
            ->with($account = new Account());

        $this->accountService->remove($account);
    }

    public function testItCreatesAccountInstanceFromFactory(): void
    {
        $expectedAccount = new Account();
        $expectedAccount->setUser($user = new User());

        $this->accountFactory
            ->expects($this->once())
            ->method('createForUser')
            ->willReturn($expectedAccount);

        $this->assertSame($expectedAccount, $this->accountService->newAccount($user));
    }
}
