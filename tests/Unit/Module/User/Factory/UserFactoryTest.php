<?php
/*
 * This file is part of the Desksheet project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desksheet\Tests\Unit\Module\User\Factory;

use Desksheet\Module\User\Factory\UserFactory;
use Desksheet\Module\User\Model\User;
use Desksheet\Module\User\Model\UserInterface;
use Desksheet\System\Factory\ResourceFactory;
use PHPUnit\Framework\TestCase;

class UserFactoryTest extends TestCase
{
    private ?UserFactory $userFactory;

    protected function setUp(): void
    {
        $this->userFactory = new UserFactory(new ResourceFactory(User::class));
    }

    protected function tearDown(): void
    {
        $this->userFactory = null;
    }

    public function testItCreateUserInstance(): void
    {
        $this->assertInstanceOf(UserInterface::class, $this->userFactory->createNew());
    }
}
