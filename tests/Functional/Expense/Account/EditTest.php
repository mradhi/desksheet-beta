<?php
/*
 * This file is part of the Desksheet project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desksheet\Tests\Functional\Expense\Account;

use Desksheet\Module\Expense\DataFixture\AccountFixtures;
use Desksheet\Module\Expense\Repository\AccountRepository;
use Desksheet\Module\User\DataFixtures\UserFixtures;
use Desksheet\Tests\Functional\WebTestCase;

class EditTest extends WebTestCase
{
    public function testUserCanUpdateHisOwnAccount(): void
    {
        $client = static::createAuthenticatedClient(UserFixtures::USER_1_REFERENCE);

        $account = static::getContainer()->get(AccountRepository::class)
            ->findOneBy(['name' => AccountFixtures::ACCOUNT_1['name']]);

        $client->request('GET', "/expense/accounts/{$account->getId()}/edit");

        $client->submitForm('btnSubmit', [
            'account[name]' => 'account_1_updated',
            'account[currency]' => 'TND'
        ]);

        $this->assertResponseRedirects('/expense/accounts/');

        $crawler = $client->followRedirect();

        $this->assertResponseIsSuccessful();

        $this->assertStringContainsString('account_1_updated', $crawler->filter('ul')->text());
    }

    public function testUserCannotUpdateOtherAccount(): void
    {
        $client = static::createAuthenticatedClient(UserFixtures::USER_1_REFERENCE);

        $account = static::getContainer()->get(AccountRepository::class)
            ->findOneBy(['name' => AccountFixtures::ACCOUNT_2['name']]);

        $client->request('GET', "/expense/accounts/{$account->getId()}/edit");

        $this->assertResponseStatusCodeSame(403);
    }
}
