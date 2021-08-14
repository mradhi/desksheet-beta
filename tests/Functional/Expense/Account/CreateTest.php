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

use Desksheet\Tests\Functional\WebTestCase;

class CreateTest extends WebTestCase
{
    public function testUserCanCreatesNewAccount(): void
    {
        $client = static::createAuthenticatedClient();

        $client->request('GET', '/expense/accounts/create');

        $client->submitForm('btnSubmit', [
            'account[name]' => 'test_account',
            'account[currency]' => 'TND'
        ]);

        $this->assertResponseRedirects('/expense/accounts/');

        $crawler = $client->followRedirect();

        $this->assertResponseIsSuccessful();

        $this->assertStringContainsString('test_account', $crawler->filter('ul')->text());
    }
}
