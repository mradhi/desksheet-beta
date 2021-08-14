<?php
/*
 * This file is part of the Desksheet project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desksheet\Tests\Unit\Module\User\Util;

use Desksheet\Module\User\Model\User;
use Desksheet\Module\User\Util\UserPasswordUpdater;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;
use Symfony\Component\PasswordHasher\Hasher\SodiumPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;

class UserPasswordUpdaterTest extends TestCase
{
    private ?UserPasswordUpdater $userPasswordUpdater;

    protected function setUp(): void
    {
        $this->userPasswordUpdater = new UserPasswordUpdater(
            new UserPasswordHasher(new PasswordHasherFactory([
                User::class => new SodiumPasswordHasher()
            ]))
        );
    }

    protected function tearDown(): void
    {
        $this->userPasswordUpdater = null;
    }

    public function testItUpdatesUserPassword(): void
    {
        $user = new User();
        $user->setPlainPassword('foobar');

        $this->assertNull($user->getPassword());

        $this->userPasswordUpdater->updatePassword($user);

        // Cleaning the plain password
        $this->assertNull($user->getPlainPassword());
        // The password property should be populated here.
        $this->assertNotNull($user->getPassword());
        // It shouldn't be the same, it should be encrypted.
        $this->assertNotSame('foobar', $user->getPassword());
    }
}
