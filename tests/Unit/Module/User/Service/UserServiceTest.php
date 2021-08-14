<?php
/*
 * This file is part of the Desksheet project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desksheet\Tests\Unit\Module\User\Service;

use Desksheet\Module\User\Factory\UserFactory;
use Desksheet\Module\User\Model\User;
use Desksheet\Module\User\Repository\UserRepository;
use Desksheet\Module\User\Service\UserService;
use Desksheet\Module\User\Util\UserPasswordUpdater;
use Desksheet\System\Manager\ResourceManagerInterface;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    private ?UserService $userService;
    private ?UserPasswordUpdater $passwordUpdater;
    private ?UserRepository $userRepository;
    private ?UserFactory $userFactory;
    private ?ResourceManagerInterface $resourceManager;

    protected function setUp(): void
    {
        $this->userService = new UserService(
            $this->passwordUpdater = $this->createMock(UserPasswordUpdater::class),
            $this->userRepository = $this->createMock(UserRepository::class),
            $this->userFactory = $this->createMock(UserFactory::class),
        );
        $this->userService->setResourceManager(
            $this->resourceManager = $this->createMock(ResourceManagerInterface::class)
        );
    }

    protected function tearDown(): void
    {
        $this->userService = null;
        $this->passwordUpdater = null;
        $this->userRepository = null;
        $this->userFactory = null;
        $this->resourceManager = null;
    }

    public function testItFindsUserByUsername(): void
    {
        $this->userRepository
            ->expects($this->once())
            ->method('findByUsername')
            ->with('foo')
            ->willReturn($user = new User());

        $this->assertSame($user, $this->userService->findByUsername('foo'));
    }

    public function testItFindsUserById(): void
    {
        $this->userRepository
            ->expects($this->once())
            ->method('findById')
            ->with(123)
            ->willReturn($user = new User());

        $this->assertSame($user, $this->userService->findById(123));
    }

    public function testItUpdatesPasswordBeforePersist(): void
    {
        $this->passwordUpdater
            ->expects($this->once())
            ->method('updatePassword')
            ->with($user = new User());

        $this->resourceManager
            ->expects($this->once())
            ->method('importAndFlush')
            ->with($user);

        $this->userService->update($user);
    }

    public function testItCreatesUserInstanceFromFactory(): void
    {
        $this->userFactory
            ->expects($this->once())
            ->method('createNew')
            ->willReturn($user = new User());

        $this->assertSame($user, $this->userService->newUser());
    }
}
