<?php
/*
 * This file is part of the Desksheet project.
 *
 * (c) Mohamed Radhi GUENNICHI <hello@guennichi.com> (https://www.guennichi.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desksheet\Module\User\Repository;

use Desksheet\Module\User\Model\UserInterface;
use Desksheet\System\Repository\ORM\ResourceRepository;

class UserRepository extends ResourceRepository
{
    public function findByUsername(?string $username): ?UserInterface
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.username = :username')
            ->setParameter('username', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
