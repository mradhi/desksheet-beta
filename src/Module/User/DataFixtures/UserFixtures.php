<?php
/*
 * This file is part of the Desksheet project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desksheet\Module\User\DataFixtures;

use Desksheet\Module\User\Enum\UserRole;
use Desksheet\Module\User\Model\User;
use Desksheet\Module\User\Util\UserPasswordUpdater;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public const USER_1_REFERENCE = 'test@mail.com';
    public const USER_2_REFERENCE = 'test_2@mail.com';

    public const USER_1 = [
        'username' => 'test@mail.com',
        'password' => 'pass',
        'roles' => [UserRole::DEFAULT]
    ];

    public const USER_2 = [
        'username' => 'test_2@mail.com',
        'password' => 'pass',
        'roles' => [UserRole::DEFAULT]
    ];

    public function __construct(private UserPasswordUpdater $passwordUpdater)
    {
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager): void
    {
        $user1 = new User();
        $user1->setUsername(self::USER_1['username']);
        $user1->setPlainPassword(self::USER_1['password']);
        $user1->setRoles(self::USER_1['roles']);

        $this->passwordUpdater->updatePassword($user1);

        $user2 = new User();
        $user2->setUsername(self::USER_2['username']);
        $user2->setPlainPassword(self::USER_2['password']);
        $user2->setRoles(self::USER_2['roles']);

        $this->passwordUpdater->updatePassword($user2);

        $manager->persist($user1);
        $manager->persist($user2);
        $manager->flush();

        $this->addReference(self::USER_1_REFERENCE, $user1);
        $this->addReference(self::USER_2_REFERENCE, $user2);
    }
}
