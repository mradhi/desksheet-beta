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
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class DeleteTest extends WebTestCase
{
    public function testUserCanDeleteHisOwnAccount(): void
    {
        $client = static::createAuthenticatedClient(UserFixtures::USER_1_REFERENCE);

        $account = static::getContainer()->get(AccountRepository::class)
            ->findOneBy(['name' => AccountFixtures::ACCOUNT_1['name']]);
        $csrfToken = static::getContainer()->get(CsrfTokenManagerInterface::class)
            ->getToken('delete_account');

        $client->request('POST', "/expense/accounts/{$account->getId()}/delete", [
            '_csrf_token' => $csrfToken
        ]);

        $this->assertResponseRedirects('/expense/accounts/');

        $crawler = $client->followRedirect();

        $this->assertResponseIsSuccessful();

        $this->assertStringNotContainsString('account_1', $crawler->filter('ul')->text());
    }

    public function testUserCannotDeleteOtherAccount(): void
    {
        $client = static::createAuthenticatedClient(UserFixtures::USER_1_REFERENCE);

        $account = static::getContainer()->get(AccountRepository::class)
            ->findOneBy(['name' => AccountFixtures::ACCOUNT_2['name']]);

        $csrfToken = static::getContainer()->get(CsrfTokenManagerInterface::class)
            ->getToken('delete_account');

        $client->request('POST', "/expense/accounts/{$account->getId()}/delete", [
            '_csrf_token' => $csrfToken
        ]);

        $this->assertResponseStatusCodeSame(403);
    }
}
