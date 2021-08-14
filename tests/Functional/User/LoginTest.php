<?php
/*
 * This file is part of the Desksheet project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desksheet\Tests\Functional\User;

use Desksheet\Module\User\DataFixtures\UserFixtures;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginTest extends WebTestCase
{
    public function testValidLoginAttemptWillRedirectToSuccessPage(): void
    {
        $client = static::createClient();

        $client->request('GET', '/login');

        $client->submitForm('btnLogin', [
            'username' => UserFixtures::USER_1['username'],
            'password' => UserFixtures::USER_1['password']
        ]);

        $this->assertResponseRedirects('/login/success');

        $client->followRedirect();

        $this->assertResponseRedirects('/profile');

        $client->followRedirect();

        $this->assertResponseIsSuccessful();
    }

    public function testIncorrectLoginAttemptWillRedirectsToLoginPath(): void
    {
        $client = static::createClient();

        $client->request('GET', '/login');

        $client->submitForm('btnLogin', [
            'username' => 'foo@bar.com',
            'password' => 'invalid_password'
        ]);

        $this->assertResponseRedirects('/login');
    }

    public function testAnonymousUserCannotAccessToSecuredArea(): void
    {
        $client = static::createClient();

        $client->request('GET', '/profile');

        $this->assertResponseRedirects('/login');

        $client->followRedirect();

        $this->assertResponseIsSuccessful();
    }
}
