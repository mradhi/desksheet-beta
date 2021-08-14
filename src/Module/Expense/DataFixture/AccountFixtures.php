<?php
/*
 * This file is part of the Desksheet project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desksheet\Module\Expense\DataFixture;

use Desksheet\Module\Expense\Model\Account;
use Desksheet\Module\User\DataFixtures\UserFixtures;
use Desksheet\Module\User\Model\UserInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AccountFixtures extends Fixture implements DependentFixtureInterface
{
    public const ACCOUNT_1 = [
        'user' => UserFixtures::USER_1_REFERENCE,
        'name' => 'account_1',
        'currency' => 'TND'
    ];

    public const ACCOUNT_2 = [
        'user' => UserFixtures::USER_2_REFERENCE,
        'name' => 'account_2',
        'currency' => 'USD'
    ];

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager): void
    {
        /** @var UserInterface $user1 */
        $user1 = $this->getReference(self::ACCOUNT_1['user']);
        /** @var UserInterface $user2 */
        $user2 = $this->getReference(self::ACCOUNT_2['user']);

        $account1 = new Account();
        $account1->setUser($user1);
        $account1->setName(self::ACCOUNT_1['name']);
        $account1->setCurrency(self::ACCOUNT_1['currency']);

        $account2 = new Account();
        $account2->setUser($user2);
        $account2->setName(self::ACCOUNT_2['name']);
        $account2->setCurrency(self::ACCOUNT_2['currency']);

        $manager->persist($account1);
        $manager->persist($account2);
        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies(): array
    {
        return [UserFixtures::class];
    }
}
