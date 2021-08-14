<?php
/*
 * This file is part of the Desksheet project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desksheet\Tests\Functional;

use Desksheet\Module\User\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;

abstract class WebTestCase extends BaseWebTestCase
{
    protected static function createAuthenticatedClient(string $username = 'test@mail.com', array $options = [], array $server = []): KernelBrowser
    {
        $client = static::createClient($options, $server);
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findByUsername($username);

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        return $client;
    }
}
