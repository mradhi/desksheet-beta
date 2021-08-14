<?php
/*
 * This file is part of the Desksheet project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desksheet\Tests\Functional\Expense;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StatusTest extends WebTestCase
{
    public function testValidUserStatus(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/expense/status');

        $response = $client->getResponse();

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame(json_encode(['success' => true]), $response->getContent());
    }
}
