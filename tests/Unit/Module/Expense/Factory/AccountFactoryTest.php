<?php
/*
 * This file is part of the Desksheet project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desksheet\Tests\Unit\Module\Expense\Factory;

use Desksheet\Module\Expense\Factory\AccountFactory;
use Desksheet\Module\Expense\Model\Account;
use Desksheet\Module\Expense\Model\AccountInterface;
use Desksheet\Module\User\Model\User;
use Desksheet\System\Factory\ResourceFactory;
use PHPUnit\Framework\TestCase;

class AccountFactoryTest extends TestCase
{
    private ?AccountFactory $accountFactory;

    protected function setUp(): void
    {
        $this->accountFactory = new AccountFactory(new ResourceFactory(Account::class));
    }

    protected function tearDown(): void
    {
        $this->accountFactory = null;
    }

    public function testItCreateAccountForUser(): void
    {
        $account = $this->accountFactory->createForUser($user = new User());

        $this->assertInstanceOf(AccountInterface::class, $account);
        $this->assertSame($user, $account->getUser());
    }

    public function testItCreateAccountInstance(): void
    {
        $this->assertInstanceOf(AccountInterface::class, $this->accountFactory->createNew());
    }
}
